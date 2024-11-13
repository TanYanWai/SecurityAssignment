<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com;");

require_once 'includes/SecurityUtils.php';

header("Content-Security-Policy: default-src 'self'; script-src 'self' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com; img-src 'self' data: https:;");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Get and sanitize the form data
$recipient_email = filter_var($_POST['recipient_email'], FILTER_SANITIZE_EMAIL);
$title = SecurityUtils::sanitize_input($_POST['title']);
$description = SecurityUtils::sanitize_input($_POST['description']);

// Validate email
if (!filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
    exit();
}

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
    exit();
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO messages (sender_email, recipient_email, title, description) VALUES (?, ?, ?, ?)");

// Bind the parameters to the prepared statement
$stmt->bind_param("ssss", $sender_email, $recipient_email, $title, $description);

// Set the sender email value
$sender_email = "admin@gmail.com";

// Execute the statement
if ($stmt->execute()) {
    session_start();
    $_SESSION['recipient_email'] = $recipient_email;
    echo "Message sent successfully!";
} else {
    echo "Failed to send message: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
