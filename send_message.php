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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query
$sql = "INSERT INTO messages (sender_email, recipient_email, title, description)
        VALUES ('admin@gmail.com', '$recipient_email', '$title', '$description')";

if ($conn->query($sql) === TRUE) {
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
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
