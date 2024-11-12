<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="Admin-Control-appointment.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
</head>

<body>
    <div class="BgAdminControlAppointment"></div>
    <div id="containerAdmin_appointment">
        <ul class="navigationAdmin">
            <li class="navigationAdmin-item"><a href="ViewAppointment.asp">View Appointment</a></li>
            <li class="navigationAdmin-item"><a href="AddAppointment.asp">Add appointment</a></li>
        </ul>
        <div id="Admin_appointment_title">
            <label class="pregnancy_detail_title" for="pragnancy_appointment">Check Appointment</label><br>
        </div>
        <div class="searchinput">
            <input id="searchAppointment" class="searchButton" type="text" name="buttonForSearch" value="Search">
        </div>

        <?php
        // Configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Assignment";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the appointment details from the database
        $stmt = $conn->prepare("SELECT * FROM appointment");
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if appointments exist
        if ($result->num_rows > 0) {
            // Iterate over the appointment records and add them to the output
            while ($row = $result->fetch_assoc()) {
                echo '<div class="container_patient">';
                echo '<div class="containerPatientTitle">';
                echo '<label class="containerPatientTitle-label">Email :</label>';
                echo '<span class="containerPatientTitle-value">' . $row["Appointment_email"] . '</span>';
                echo '</div>';
                echo '<div class="detail-row">';
                echo '<label class="detail-label">Name :</label>';
                echo '<span class="detail-value">' . $row["Appointment_name"] . '</span>';
                echo '</div>';
                echo '<div class="detail-row">';
                echo '<label class="detail-label">Time :</label>';
                echo '<span class="detail-value">' . $row["Appointment_time"] . '</span>';
                echo '</div>';
                echo '<div class="detail-row">';
                echo '<label class="detail-label">Appointment Date:</label>';
                echo '<span class="detail-value">' . $row["Appointment_date"] . '</span>';
                echo '</div>';
                echo '<div class="detail-row">';
                echo '<label class="detail-label">Appointment Room:</label>';
                echo '<span class="detail-value">' . $row["Appointment_room"] . '</span>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No appointments found.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>

    </div>

</body>

</html>