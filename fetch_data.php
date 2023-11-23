<?php
// fetch_data.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "training";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["country_id"])) {
        $countryId = $_POST["country_id"];

        // Fetch states based on the selected country
        $sql = "SELECT id, name FROM states WHERE country_id = $countryId";
        $result = $conn->query($sql);

        $states = array();
        while ($row = $result->fetch_assoc()) {
            $states[] = $row;
        }

        echo json_encode($states);
    } elseif (isset($_POST["state_id"])) {
        $stateId = $_POST["state_id"];

        // Fetch cities based on the selected state
        $sql = "SELECT id, name FROM cities WHERE state_id = $stateId";
        $result = $conn->query($sql);

        $cities = array();
        while ($row = $result->fetch_assoc()) {
            $cities[] = $row;
        }

        echo json_encode($cities);
    }
}

$conn->close();
?>
