<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Assignment";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the room number and serving number from the request
$room = $_POST['room'];
$servingNumber = $_POST['servingNumber'];

// Update the serving number in the database
$sql = "UPDATE queue SET serving_number = '$servingNumber' WHERE room = '$room'";
if ($conn->query($sql) === TRUE) {
    echo "Serving number updated successfully.";
} else {
    echo "Error updating serving number: " . $conn->error;
}

$conn->close();
?>