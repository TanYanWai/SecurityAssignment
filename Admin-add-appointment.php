<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "assignment"; 

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $selectedDate = $_POST['selectedDate'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contract = $_POST['contract'];
    $address = $_POST['address'];
    $time = $_POST['time'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO appointments (selected_date, name, email, contract, address, time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $selectedDate, $name, $email, $contract, $address, $time);

    if ($stmt->execute()) {
        echo "Appointment saved successfully.";
    } else {
        echo "Failed to save the appointment: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>