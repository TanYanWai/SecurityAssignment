<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the serving numbers from the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room = $_POST['room'];
    $servingNumber = $_POST['servingNumber'];

    // Prepare the SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO queue (room, serving_number) VALUES (?, ?)");

    // Bind the user input to the placeholders
    $stmt->bind_param("si", $room, $servingNumber);  // 's' for string, 'i' for integer

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
