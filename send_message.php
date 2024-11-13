<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Get data from form
$recipient_email = $_POST['recipient_email'];
$title = $_POST['title'];
$description = $_POST['description'];

// Create database connection
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

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO messages (sender_email, recipient_email, title, description) VALUES (?, ?, ?, ?)");

// Bind the parameters to the prepared statement
$sender_email = "admin@gmail.com";
$stmt->bind_param("ssss", $sender_email, $recipient_email, $title, $description);

// Execute the query and check for success
if ($stmt->execute()) {
    session_start();
    $_SESSION['recipient_email'] = $recipient_email;

    // Log message activity
    $log_file = __DIR__ . "/logs/user_activity.log";  // Path to the log file
    $current_time = date("Y-m-d H:i:s");
    $log_message = "User sent a message to $recipient_email with title '$title' at $current_time\n";

    // Ensure the logs directory exists
    if (!file_exists(__DIR__ . "/logs")) {
        mkdir(__DIR__ . "/logs", 0777, true);  // Create 'logs' directory if not exists
    }

    // Write to the log file
    if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
        echo "Error logging user activity!";
    }

    // Success message
    echo "Message sent successfully!";
} else {
    // Error Handling: Output detailed error if query fails
    echo "Error: " . $stmt->error;
}

// Close the statement
$stmt->close();
// Close the connection
$conn->close();
?>
