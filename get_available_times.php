<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Assignment";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the selected date from the query string
$date = $_GET['date'];

// Prepare and execute the SQL query to retrieve booked times for the selected date
$stmt = $conn->prepare("SELECT DISTINCT Appointment_time FROM appointment WHERE Appointment_date = ?");
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$bookedTimes = array();
while ($row = $result->fetch_assoc()) {
    $bookedTimes[] = $row["Appointment_time"];
}

// Generate select options excluding booked times
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

// Close the statement and connection
$stmt->close();
$conn->close();
?>