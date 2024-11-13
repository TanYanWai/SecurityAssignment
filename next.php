<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected room from POST request
$selectedRoom = $_POST['room'];

// Prepared statement for updating the queue number
$stmt = $conn->prepare("UPDATE queue_table SET queue_number = queue_number + 1 WHERE room_number = ?");
$stmt->bind_param("s", $selectedRoom);  // "s" indicates the parameter is a string

if ($stmt->execute() !== true) {
    echo "Error updating queue number: " . $stmt->error;
}

// Prepared statement for updating the current room
$stmt = $conn->prepare("UPDATE queue_table SET is_current = CASE WHEN room_number = ? THEN 1 ELSE 0 END");
$stmt->bind_param("s", $selectedRoom);  // "s" indicates the parameter is a string

if ($stmt->execute() !== true) {
    echo "Error updating current room: " . $stmt->error;
}

// Close the prepared statement and connection
$stmt->close();
$conn->close();

// Redirect to admin page
header("Location: admin.php");
exit();
?>
