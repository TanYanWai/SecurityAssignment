<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com;");
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "assignment"; 

// Establish connection to the database
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the log file path
$log_file = __DIR__ . "/logs/user_activity.log";  // Path to log file

// Ensure the logs directory exists
if (!file_exists(__DIR__ . "/logs")) {
    mkdir(__DIR__ . "/logs", 0777, true);  // Create 'logs' directory if not exists
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $selectedDate = $_POST['selectedDate'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contract = $_POST['contract'];
    $address = $_POST['address'];
    $time = $_POST['time'];

    // Log the appointment attempt
    $current_time = date("Y-m-d H:i:s");
    $log_message = "Attempted to save appointment for $name (email: $email) on $selectedDate at $time. Time: $current_time\n";

    if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
        echo "Error logging appointment attempt!";
    }

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO appointments (selected_date, name, email, contract, address, time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $selectedDate, $name, $email, $contract, $address, $time);

    if ($stmt->execute()) {
        // Log successful appointment creation
        $log_message = "Appointment successfully saved for $name (email: $email) on $selectedDate at $time. Time: $current_time\n";
        if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
            echo "Error logging successful appointment creation!";
        }
        echo "Appointment saved successfully.";
    } else {
        // Log failed appointment creation
        $log_message = "Failed to save appointment for $name (email: $email) on $selectedDate at $time. Error: " . $stmt->error . "\n";
        if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
            echo "Error logging failed appointment!";
        }
        echo "Failed to save the appointment: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
