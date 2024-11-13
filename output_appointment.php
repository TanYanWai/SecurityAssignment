<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="output_appointment.css">
    <link rel="stylesheet" href="HomePage.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
</head>
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
            <a href="ForAppointment.html" class="buttonItSlef details">APPOINTMENT</a>
        </div>
    </div>

    <div class="navigation">
        <div class="brand">
            <a href=" " class="logo"><i class="fas fa-heartbeat"></i><b> Island Pregnancy Clinic</b></a >
        </div>
        <div class="nav">
           <a href="HomePage.html">Home</a >
           <a href="admin.html">Live Queue</a >
           <a href="Message.html">Send Message</a >
           <a href="output_message.php">Receive Message</a >
           <a href="Pregnancy_report1.html">Report</a >
        </div>
    </div>
</header>

<body>
    <div class="BgAdminControlAppointment"></div>
    <div id="containerAdmin_appointment">
        <div id="Admin_appointment_title">
            <label class="pregnancy_detail_title" for="pragnancy_appointment">Check Appointment</label><br>
        </div>
      
        <?php
// Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query (no user input here)
$sql = "SELECT * FROM appointment";

// Prepare the query
$stmt = $conn->prepare($sql);

// Check if the query was prepared successfully
if ($stmt === false) {
    die('Error preparing the statement: ' . $conn->error);
}

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if appointments exist
if ($result->num_rows > 0) {
    // Iterate over the appointment records and add them to the output
    while ($row = $result->fetch_assoc()) {
        echo '<div class="container_patient">';
        echo '<div class="containerPatientTitle">';
        echo '<label class="containerPatientTitle-label">Email :</label>';
        echo '<span class="containerPatientTitle-value">' . htmlspecialchars($row["Appointment_email"]) . '</span>';
        echo '</div>';
        echo '<div class="detail-row">';
        echo '<label class="detail-label">Name :</label>';
        echo '<span class="detail-value">' . htmlspecialchars($row["Appointment_name"]) . '</span>';
        echo '</div>';
        echo '<div class="detail-row">';
        echo '<label class="detail-label">Time :</label>';
        echo '<span class="detail-value">' . htmlspecialchars($row["Appointment_time"]) . '</span>';
        echo '</div>';
        echo '<div class="detail-row">';
        echo '<label class="detail-label">Appointment Date:</label>';
        echo '<span class="detail-value">' . htmlspecialchars($row["Appointment_date"]) . '</span>';
        echo '</div>';
        echo '<div class="detail-row">';
        echo '<label class="detail-label">Appointment Room:</label>';
        echo '<span class="detail-value">' . htmlspecialchars($row["Appointment_room"]) . '</span>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No appointments found.";
}

// Close the connection
$conn->close();
?>


    </div>

</body>
</html>
