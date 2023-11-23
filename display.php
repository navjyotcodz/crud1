<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>Display Data</h2>

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

    // Fetch data from the database with join
    $sql = "SELECT users.id, users.firstname, users.lastname, users.gender, users.interests,
                   countries.name AS country, states.name AS state, cities.name AS city
            FROM users
            JOIN countries ON users.country = countries.id
            JOIN states ON users.state = states.id
            JOIN cities ON users.city = cities.id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Interests</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Action</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['lastname']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['interests']}</td>
                    <td>{$row['country']}</td>
                    <td>{$row['state']}</td>
                    <td>{$row['city']}</td>
                    <td>
                        <a href='update.php?id={$row["id"]}'>Edit</a> |
                        <a href='delete.php?id={$row["id"]}'>Delete</a>
                    </td>
                  </tr>";
        }

        echo "</table>";
        // Add a div for action buttons
        // echo "<div class='action-buttons'>
        //         <a href='add.php'>Add New Record</a>
        //     </div>";
    } else {
        echo "No records found";
    }

    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
