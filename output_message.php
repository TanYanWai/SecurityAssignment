<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com;");

require_once 'includes/SecurityUtils.php';

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM messages WHERE recipient_email = ?");
$stmt->bind_param("s", $_SESSION['recipient_email']); // "s" denotes the type (string)

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('No messages found for the recipient email: " . SecurityUtils::sanitize_output($_SESSION['recipient_email']) . "');
        window.location.href = 'Message.html';  // Optional: redirect back to message page
    </script>";
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
            <script src="SessionManagement.js"></script>
            <style>
                .message-container-wrapper {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    overflow-y: auto;
                }

                .message-container {
                    margin-bottom: 20px;
                    padding: 20px;
                    border: 1px solid #f2c7c7;
                    background-color: #rgb(255, 244, 255);
                    width: 400px;
                    display: flex;
                    flex-direction: column;
                    margin-top: 20px;
                    max-width: 90%;
                }

                .message {
                    margin-bottom: 10px;
                }

                .message-sender {
                    font-weight: bold;
                }

                .message-title,
                .message-description {
                    margin-left: 10px;
                }

                .bg_message1 {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: -1;
                    background-image: url("https://relay.firefox.com/_next/static/media/features-reply-to-emails-anon.f9e57d5c.svg");
                    background-size: cover;
                }
            </style>
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
            <div class="transparent_button">
                <a href="ForAppointment.html" class="buttonItSlef details">BOOK APPOINTMENT</a>
            </div>
        </div>

        <div class="navigation">
            <div class="brand">
                <a href=" " class="logo"><i class="fas fa-heartbeat"></i><b> Island Pregnancy Clinic</b></a >
            </div>
            <div class="nav">
               <a href="HomePage.html">Home</a >
               <a href="LiveQueue.html">Live Queue</a >
               <a href="Message.html">Send Message</a >
               <a href="output_message.php">Receive Message</a >
               <a href="Pregnancy_report1.html">Report</a >
            </div>
        </div>
    </header>
    ';

    echo '<div class="message-container-wrapper">';
    echo '<div class="parent-container">';
    echo '<div class="all_message">';

    while ($row = $result->fetch_assoc()) {
        echo '<div class="bg_message1"></div>';
        echo '<div class="message-container">';
        echo '<div class="message">';
        echo '<div class="message-sender">From: ' . SecurityUtils::sanitize_output($row['sender_email']) . '</div>';
        echo '<div class="message-title">Title: ' . SecurityUtils::sanitize_output($row['title']) . '</div>';
        echo '<div class="message-description">Description: ' . SecurityUtils::sanitize_output($row['description']) . '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}


// Close the connection
$conn->close();
?>
