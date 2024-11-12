<!DOCTYPE html>
<html>
<head>
    <title>Message Output</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            margin-bottom: 20px;
        }
        .message-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .message-title {
            font-weight: bold;
        }
        .message-description {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h2>Message Output</h2>

    <?php
$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

// Create a new mysqli connection
$conn = mysqli_connect($server_name, $username, $password, $database_name);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming you have received the IC number via GET or POST
$icNumber = $_POST['icNumber']; // or $_GET['icNumber']

// Prepare the SQL statement to select messages based on IC number
$sql = "SELECT * FROM message WHERE icNumber = ?";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

// Bind the parameter (s for string, i for integer, etc.)
mysqli_stmt_bind_param($stmt, "s", $icNumber); // 's' indicates the type is string

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Output the messages
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="message-container">';
        echo '<div class="message-title">' . $row['title'] . '</div>';
        echo '<div class="message-description">' . $row['description'] . '</div>';
        echo '</div>';
    }
} else {
    echo "No messages found for the selected IC number.";
}

// Close the prepared statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
