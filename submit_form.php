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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $interests = implode(", ", $_POST["interests"]); // Convert array to comma-separated string
    $country = $_POST["country"];
    $state = $_POST["state"];
    $city = $_POST["city"];

    // Insert data into the database
    $sql = "INSERT INTO users (firstname, lastname, gender, interests, country, state, city)
            VALUES ('$firstname', '$lastname', '$gender', '$interests', '$country', '$state', '$city')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
 header("Location: display.php");
?>
 