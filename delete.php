<?php
// delete.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "training";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $userId = $_GET["id"];

    // Delete user data from the database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
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
