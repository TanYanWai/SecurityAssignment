<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Assignment";


$recipient_email = $_POST['recipient_email'];
$title = $_POST['title'];
$description = $_POST['description'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO messages (sender_email, recipient_email, title, description)
        VALUES ('admin@gmail.com', '$recipient_email', '$title', '$description')";

if ($conn->query($sql) === TRUE) {
  session_start();
  $_SESSION['recipient_email'] = $recipient_email;

  echo "Message sent successfully!";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>