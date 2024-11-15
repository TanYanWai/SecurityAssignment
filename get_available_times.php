<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com;");
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

$date = $_GET['date'];

$stmt = $conn->prepare("SELECT DISTINCT Appointment_time FROM appointment WHERE Appointment_date = ?");
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$bookedTimes = array();
while ($row = $result->fetch_assoc()) {
    $bookedTimes[] = $row["Appointment_time"];
}

$availableTimes = array(
    "08.00-09:00",
    "09:00-10:00",
    "10:00-11:00",
    "11:00-12:00",
    "12:00-13:00",
    "13:00-14:00",
    "14:00-15:00",
    "15:00-16:00",
    "16:00-17:00",
    "17:00-18:00"
);

$options = "";
foreach ($availableTimes as $time) {
    if (!in_array($time, $bookedTimes)) {
        $options .= "<option value='$time'>$time</option>";
    }
}

echo $options;

$stmt->close();
$conn->close();
?>