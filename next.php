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

$selectedRoom = $_POST['room'];

$sql = "UPDATE queue_table SET queue_number = queue_number + 1 WHERE room_number = '$selectedRoom'";
if ($conn->query($sql) !== true) {
    echo "Error updating queue number: " . $conn->error;
}

$sql = "UPDATE queue_table SET is_current = CASE WHEN room_number = '$selectedRoom' THEN 1 ELSE 0 END";
if ($conn->query($sql) !== true) {
    echo "Error updating current room: " . $conn->error;
}

$conn->close();

header("Location: admin.php");
exit();
?>