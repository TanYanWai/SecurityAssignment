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
    // Error Handling: Connection error
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$appointmentDate = $_POST['Appointment_date'];
$appointmentTime = $_POST['Appointment_time'];
$appointmentEmail = $_POST['Appointment_email'];
$appointmentName = $_POST['Appointment_name'];
$appointmentRoom = $_POST['Appointment_room'];

// Validation: Check if required fields are filled in
if (empty($appointmentDate) || empty($appointmentTime) || empty($appointmentEmail) || empty($appointmentName) || empty($appointmentRoom)) {
    die("All fields are required. Please fill in all the fields.");
}

// Validation: Check if email is in valid format
if (!filter_var($appointmentEmail, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

// Create SQL query directly
$sql = "INSERT INTO appointment (Appointment_date, Appointment_time, Appointment_email, Appointment_name, Appointment_room) 
        VALUES ('$appointmentDate', '$appointmentTime', '$appointmentEmail', '$appointmentName', '$appointmentRoom')";

// Error Handling: Check if query executes successfully
if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully!";
} else {
    // Error Handling: Output detailed error if query fails
    echo "Error inserting data: " . $conn->error;
}

// Close the connection
$conn->close();
?>
