<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2>Edit User</h2>

    <?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "training";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $userId = $_GET["id"];

        // Fetch data of the selected user
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Display form with user data for editing
            echo "<form action='update_process.php' method='post'>
                    <input type='hidden' name='id' value='{$row["id"]}'>
                    
                    <label for='firstname'>First Name:</label>
                    <input type='text' id='firstname' name='firstname' value='{$row["firstname"]}' required><br>

                    <label for='lastname'>Last Name:</label>
                    <input type='text' id='lastname' name='lastname' value='{$row["lastname"]}' required><br>

                    <label>Gender:</label>
                    <input type='radio' id='male' name='gender' value='male' ".($row["gender"]=="male" ? "checked" : "").">
                    <label for='male'>Male</label>
                    <input type='radio' id='female' name='gender' value='female' ".($row["gender"]=="female" ? "checked" : "").">
                    <label for='female'>Female</label><br>

                    <label>Interests:</label>
                    <input type='checkbox' id='coding' name='interests[]' value='coding' ".(in_array("coding", explode(", ", $row["interests"])) ? "checked" : "").">
                    <label for='coding'>Coding</label>
                    <input type='checkbox' id='reading' name='interests[]' value='reading' ".(in_array("reading", explode(", ", $row["interests"])) ? "checked" : "").">
                    <label for='reading'>Reading</label>
                    <input type='checkbox' id='traveling' name='interests[]' value='traveling' ".(in_array("traveling", explode(", ", $row["interests"])) ? "checked" : "").">
                    <label for='traveling'>Traveling</label><br>

                    <label for='country'>Country:</label>
                    <select id='country' name='country' >
                        <!-- Fetch and populate countries from the database -->
                    </select><br>

                    <label for='state'>State:</label>
                    <select id='state' name='state' >
                        <!-- Fetch and populate states based on the selected country using JavaScript -->
                    </select><br>

                    <label for='city'>City:</label>
                    <select id='city' name='city' >
                        <!-- Fetch and populate cities based on the selected state using JavaScript -->
                    </select><br>

                    <input type='submit' value='Update'>
                </form>";

            // Fetch and set the selected country, state, and city using JavaScript
            echo "<script>
                    $(document).ready(function () {
                        // Fetch and populate countries
                        $.ajax({
                            type: 'POST',
                            url: 'fetch_data.php',
                            data: { action: 'fetch_countries' },
                            dataType: 'json',
                            success: function (data) {
                                var options = '<option value=''>Select Country</option>';
                                for (var i = 0; i < data.length; i++) {
                                    options += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
                                }
                                $('#country').html(options).val('{$row["country"]}');

                                // Trigger the change event to fetch and populate states based on the selected country
                                $('#country').change();
                            }
                        });
                    });
                </script>";

            echo "<script>
                    // Fetch and populate states based on the selected country using JavaScript
                    $(document).ready(function () {
                        var countryId = '{$row["country"]}';

                        $.ajax({
                            type: 'POST',
                            url: 'fetch_data.php',
                            data: { action: 'fetch_states', country_id: countryId },
                            dataType: 'json',
                            success: function (data) {
                                var options = '<option value=''>Select State</option>';
                                for (var i = 0; i < data.length; i++) {
                                    options += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
                                }
                                $('#state').html(options).val('{$row["state"]}');

                                // Trigger the change event to fetch and populate cities based on the selected state
                                $('#state').change();
                            }
                        });
                    });
                </script>";

            echo "<script>
                    // Fetch and populate cities based on the selected state using JavaScript
                    $(document).ready(function () {
                        var stateId = '{$row["state"]}';

                        $.ajax({
                            type: 'POST',
                            url: 'fetch_data.php',
                            data: { action: 'fetch_cities', state_id: stateId },
                            dataType: 'json',
                            success: function (data) {
                                var options = '<option value=''>Select City</option>';
                                for (var i = 0; i < data.length; i++) {
                                    options += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
                                }
                                $('#city').html(options).val('{$row["city"]}');
                            }
                        });
                    });
                </script>";
        } else {
            echo "User not found";
        }
    } else {
        echo "Invalid request";
    }

    $conn->close();
    ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add this script tag in the head section of your HTML -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        // Include your JavaScript code for dynamically populating states and cities based on country and state selections
    </script>

</body>
</html>
