<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$appointmentDate = $_POST['Appointment_date'];
$appointmentTime = $_POST['Appointment_time'];
$appointmentEmail = $_POST['Appointment_email'];
$appointmentName = $_POST['Appointment_name'];
$appointmentRoom = $_POST['Appointment_room'];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO appointment (Appointment_date, Appointment_time, Appointment_email, Appointment_name, Appointment_room) 
                        VALUES (?, ?, ?, ?, ?)");

// Bind parameters to the prepared statement
$stmt->bind_param("sssss", $appointmentDate, $appointmentTime, $appointmentEmail, $appointmentName, $appointmentRoom);

// Execute the statement
if ($stmt->execute()) {
    echo "Data inserted successfully";
} else {
    echo "Error inserting data: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
