<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Get the form data
$recipient_email = $_POST['recipient_email'];
$title = $_POST['title'];
$description = $_POST['description'];

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
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
  echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
