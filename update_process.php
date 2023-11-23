<?php
// update_process.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "training";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $userId = $_POST["id"];
    $newFirstname = $_POST["firstname"];
    
    // Include other fields as needed

    // Update user data in the database
    $sql = "UPDATE users SET firstname = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newFirstname, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: display.php");

    } else {
        header("Location: display.php");

    }
} else {
    header("Location: display.php");

}

$conn->close();
?>

