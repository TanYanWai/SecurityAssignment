<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com;");

require_once 'includes/SecurityUtils.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

$conn = mysqli_connect($server_name, $username, $password, $database_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $icNumber = SecurityUtils::sanitize_input($_POST['icNumber']);
    $title = SecurityUtils::sanitize_input($_POST['title']);
    $description = SecurityUtils::sanitize_input($_POST['description']);

    // Prepare the SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO message (icNumber, title, description) VALUES (?, ?, ?)");
    
    // Bind the user input to the prepared statement parameters
    $stmt->bind_param("sss", $icNumber, $title, $description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Message sent successfully.";
    } else {
        echo "Error: " . SecurityUtils::sanitize_output($stmt->error);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
mysqli_close($conn);
?>
