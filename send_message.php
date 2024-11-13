<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Retrieve form data
$recipient_email = $_POST['recipient_email'];
$title = $_POST['title'];
$description = $_POST['description'];

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Error Handling: Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
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
$sql = "INSERT INTO messages (sender_email, recipient_email, title, description)
        VALUES ('admin@gmail.com', '$recipient_email', '$title', '$description')";

// Error Handling: Check if query executes successfully
if ($conn->query($sql) === TRUE) {
  // Start session and set session variable
  session_start();
  $_SESSION['recipient_email'] = $recipient_email;

  echo "Message sent successfully!";
} else {
  // Error Handling: Output detailed error if query fails
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
