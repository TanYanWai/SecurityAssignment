<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patientrecord";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the serving numbers from the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room = $_POST['room'];
    $servingNumber = $_POST['servingNumber'];

    // Insert the serving numbers into the database
    $sql = "INSERT INTO queue (room, serving_number) VALUES ('$room', '$servingNumber')";
    $conn->query($sql);
}
?>
