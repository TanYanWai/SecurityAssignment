<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration for database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Define the log file path for user activity logs
$log_file = __DIR__ . "/logs/user_activity.log";  // Path to log file

// Ensure the logs directory exists
if (!file_exists(__DIR__ . "/logs")) {
    mkdir(__DIR__ . "/logs", 0777, true);  // Create 'logs' directory if it does not exist
}

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

// Log the appointment attempt
$current_time = date("Y-m-d H:i:s");
$log_message = "Attempted to insert appointment for $appointmentName (email: $appointmentEmail) on $appointmentDate at $appointmentTime in room $appointmentRoom. Time: $current_time\n";

// Log the attempt to the user activity log
if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
    echo "Error logging appointment attempt!";
}

$stmt = $conn->prepare("INSERT INTO appointment (Appointment_date, Appointment_time, Appointment_email, Appointment_name, Appointment_room) 
                        VALUES (?, ?, ?, ?, ?)");

// Bind parameters to the prepared statement
$stmt->bind_param("sssss", $appointmentDate, $appointmentTime, $appointmentEmail, $appointmentName, $appointmentRoom);


// Execute the query and log results
if ($conn->query($sql) === TRUE) {
    // Log successful insertion
    $log_message = "Successfully inserted appointment for $appointmentName (email: $appointmentEmail) on $appointmentDate at $appointmentTime in room $appointmentRoom. Time: $current_time\n";
    if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
        echo "Error logging successful insertion!";
    }
    echo "Data inserted successfully.";
} else {
    // Error Handling: Output detailed error if fails
    // Log error in case of failure
    $log_message = "Failed to insert appointment for $appointmentName (email: $appointmentEmail) on $appointmentDate at $appointmentTime in room $appointmentRoom. Error: " . $conn->error . " Time: $current_time\n";
    if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
        echo "Error logging failed insertion!";
    }
    echo "Error inserting data: " . $conn->error;
}

// Close the connection
$conn->close();
?>
