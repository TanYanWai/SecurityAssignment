<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com;");

require_once 'includes/SecurityUtils.php';

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

// Error Handling: Check connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
    exit();
}

// Validation: Check if required fields are filled in
if (empty($recipient_email) || empty($title) || empty($description)) {
  die("All fields are required. Please fill in all the fields.");
}

// Validation: Check title length (e.g., max 255 characters)
if (strlen($title) > 255) {
  die("Title must be 255 characters or fewer.");
}

// Validation: Check description length (e.g., max 1000 characters)
if (strlen($description) > 1000) {
  die("Description must be 1000 characters or fewer.");
}

// SQL query to insert message data
// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO messages (sender_email, recipient_email, title, description) VALUES (?, ?, ?, ?)");

// Bind the parameters to the prepared statement
$stmt->bind_param("ssss", $sender_email, $recipient_email, $title, $description);

// Error Handling: Check if query executes successfully
$sender_email = "admin@gmail.com";

// Execute the statement
if ($stmt->execute()) {
    session_start();
    $_SESSION['recipient_email'] = $recipient_email;
    echo "Message sent successfully!";
} else {
    echo "Failed to send message: " . $stmt->error;
}

// Close the statement
$stmt->close();
// Close the connection
$conn->close();
?>
