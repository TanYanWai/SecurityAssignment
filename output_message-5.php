<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Assignment";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM messages WHERE recipient_email = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $_SESSION['recipient_email']);

if (!$stmt->execute()) {
    die("Query Execution Failed: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No messages found for the recipient email " . $_SESSION['recipient_email'];
} else {
    echo '<div class="container">';
    echo '
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Klinik Kesihatan</title>
            <link rel="stylesheet" href="HomePage.css">
            <link rel="stylesheet" href="output_message.css">
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        </head>
        <body>
        <header class="header">
            <div class="top_header">
                <div class="contacts">
                    <div class="contact_email">
                        <span><ion-icon name="mail-outline"></ion-icon> CKlinik@gamil.com</span>
                    </div>
                    <div class="contact_phone">
                        <span><ion-icon name="call-outline"></ion-icon>+604 222 2222</span>
                    </div>
                </div>
                <button class="transparent_button">APPOINTMENT</button>
            </div>

            <div class="navigation">
                <div class="brand">
                    <a href=" " class="logo"><i class="fas fa-heartbeat"></i><b> Island Pregnancy Clinic</b></a >
                </div>
                <div class="nav">
                   <a href="HomePage.html">Home</a >
                   <a href="LiveQueue.html">Live Queue</a >
                   <a href="Message.html">Notification</a >
                   <a href="output_message.php">Receive Message</a >
                   <a href="Pregnancy_report1.html">Report</a >
                </div>
            </div>
        </header>
        ';

        echo '<div class="message-container-wrapper">'; 

while ($row = $result->fetch_assoc()) {

    echo '<div class="message-container">';
    echo '<div class="message">';
    echo '<div class="message-sender">Sender: ' . $row['sender_email'] . '</div>';
    echo '<div class="message-title">Title: ' . $row['title'] . '</div>';
    echo '<div class="message-description">Description: ' . $row['description'] . '</div>';
    echo '</div>';
    echo '</div>';
}

echo '</div>';
}

$stmt->close();
$conn->close();
?>