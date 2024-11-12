<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Assignment";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the room number and serving number from the request
$room = $_POST['room'];
$servingNumber = $_POST['servingNumber'];

// Prepare the SQL statement with placeholders
$sql = "UPDATE queue SET serving_number = ? WHERE room = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Check if preparation was successful
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the parameters to the placeholders
$stmt->bind_param("ss", $servingNumber, $room);

// Execute the statement
if ($stmt->execute()) {
    echo "Serving number updated successfully.";
} else {
    echo "Error updating serving number: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
