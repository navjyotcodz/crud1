<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Form</title>
</head>
<body>

    <h2>CRUD Form</h2>

    <form action="submit_form.php" method="post">
        <!-- First Name -->
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br>

        <!-- Last Name -->
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br>

        <!-- Gender -->
        <label>Gender:</label>
        <input type="radio" id="male" name="gender" value="male" checked>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">Female</label><br>

        <!-- Interests -->
        <label>Interests:</label>
        <input type="checkbox" id="coding" name="interests[]" value="coding">
        <label for="coding">Coding</label>
        <input type="checkbox" id="reading" name="interests[]" value="reading">
        <label for="reading">Reading</label>
        <input type="checkbox" id="traveling" name="interests[]" value="traveling">
        <label for="traveling">Traveling</label><br>

        <!-- Country Dropdown -->
        <label for="country">Country:</label>
        <select id="country" name="country" required>
            <?php
                // Fetch countries from the database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "training";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, name FROM countries";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
                }

                $conn->close();
            ?>
        </select><br>

        <!-- State Dropdown -->
        <label for="state">State:</label>
        <select id="state" name="state" required>
            <!-- States will be populated dynamically using JavaScript after selecting a country -->
        </select><br>

        <!-- City Dropdown -->
        <label for="city">City:</label>
        <select id="city" name="city" required>
            <!-- Cities will be populated dynamically using JavaScript after selecting a state -->
        </select><br>

        <!-- Submit Button -->
        <input type="submit" value="Submit">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add this script tag in the head section of your HTML -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function fetchStates() {
        var countryId = $("#country").val();

        $.ajax({
            type: "POST",
            url: "fetch_data.php", // Updated URL
            data: { country_id: countryId },
            dataType: "json",
            success: function (data) {
                var options = '<option value="">Select State</option>';
                for (var i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }
                $("#state").html(options);
            }
        });
    }

    function fetchCities() {
        var stateId = $("#state").val();

        $.ajax({
            type: "POST",
            url: "fetch_data.php", // Updated URL
            data: { state_id: stateId },
            dataType: "json",
            success: function (data) {
                var options = '<option value="">Select City</option>';
                for (var i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }
                $("#city").html(options);
            }
        });
    }

    $(document).ready(function () {
        $("#country").change(fetchStates);
        $("#state").change(fetchCities);
    });
</script>

</body>
</html>
