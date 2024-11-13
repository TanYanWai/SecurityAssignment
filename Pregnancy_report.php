<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com;");
require_once 'includes/SecurityUtils.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

$conn = mysqli_connect($server_name, $username, $password, $database_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['report_button'])) {
    // Initialize variables with sanitization
    $report_Ic_Number = isset($_POST['report_Ic_Number']) ? SecurityUtils::sanitize_input($_POST['report_Ic_Number']) : '';
    $report_month = isset($_POST['report_month']) ? SecurityUtils::sanitize_input($_POST['report_month']) : '';
    $report_first_name = isset($_POST['report_first_name']) ? SecurityUtils::sanitize_input($_POST['report_first_name']) : '';
    $report_last_name = isset($_POST['report_last_name']) ? SecurityUtils::sanitize_input($_POST['report_last_name']) : '';
    $report_patient_tel = isset($_POST['report_patient_tel']) ? SecurityUtils::sanitize_input($_POST['report_patient_tel']) : '';
    $report_patient_birthday = isset($_POST['report_patient_birthday']) ? SecurityUtils::sanitize_input($_POST['report_patient_birthday']) : '';
    $report_patient_email = isset($_POST['report_patient_email']) ? SecurityUtils::sanitize_input($_POST['report_patient_email']) : '';
    $report_patient_address1 = isset($_POST['report_patient_address1']) ? SecurityUtils::sanitize_input($_POST['report_patient_address1']) : '';
    $report_patient_address2 = isset($_POST['report_patient_address2']) ? SecurityUtils::sanitize_input($_POST['report_patient_address2']) : '';
    $report_first_city = isset($_POST['report_first_city']) ? SecurityUtils::sanitize_input($_POST['report_first_city']) : '';
    $report_state = isset($_POST['report_state']) ? SecurityUtils::sanitize_input($_POST['report_state']) : '';
    $report_postal = isset($_POST['report_postal']) ? SecurityUtils::sanitize_input($_POST['report_postal']) : '';
    $bloodPressure = isset($_POST['bloodPressure']) ? SecurityUtils::sanitize_input($_POST['bloodPressure']) : '';
    $weight1 = isset($_POST['weight1']) ? SecurityUtils::sanitize_input($_POST['weight1']) : '';
    $ultraSound = isset($_POST['ultraSound']) ? SecurityUtils::sanitize_input($_POST['ultraSound']) : '';
    $fetalHeartRate = isset($_POST['fetalHeartRate']) ? SecurityUtils::sanitize_input($_POST['fetalHeartRate']) : '';
    $maternalSymptoms = isset($_POST['maternalSymptoms']) ? SecurityUtils::sanitize_input($_POST['maternalSymptoms']) : '';
    $immunizations = isset($_POST['immunizations']) ? SecurityUtils::sanitize_input($_POST['immunizations']) : '';
    $doctorreport = isset($_POST['doctorreport']) ? SecurityUtils::sanitize_input($_POST['doctorreport']) : '';

    // Basic validation
    $errors = [];
    if (empty($report_Ic_Number) || !preg_match('/^\d{12}$/', $report_Ic_Number)) {
        $errors[] = "IC Number is required and must be 12 digits.";
    }
    if (empty($report_month)) $errors[] = "Pregnancy Month is required.";
    if (empty($report_first_name)) $errors[] = "First Name is required.";
    if (empty($report_last_name)) $errors[] = "Last Name is required.";
    if (empty($report_patient_tel) || !preg_match('/^\d{10}$/', $report_patient_tel)) {
        $errors[] = "Phone Number is required and must be 10 digits.";
    }
    if (empty($report_patient_birthday)) $errors[] = "Birthday is required.";
    if (empty($report_patient_email)) $errors[] = "Email is required.";
    if (empty($report_patient_address1)) $errors[] = "Address1 is required.";
    if (empty($report_first_city)) $errors[] = "City is required.";
    if (empty($report_state)) $errors[] = "State is required.";
    if (empty($report_postal) || !preg_match('/^\d{5}$/', $report_postal)) {
        $errors[] = "Postal Code is required and must be 5 digits.";
    }
    // Validate numeric fields (blood pressure, weight, ultrasound, fetal heart rate)
    if (empty($bloodPressure) || !is_numeric($bloodPressure)) {
        $errors[] = "Blood Pressure must be numeric.";
    }
    if (empty($weight1) || !is_numeric($weight1)) {
        $errors[] = "Weight must be numeric.";
    }
    if (empty($ultraSound) || !is_numeric($ultraSound)) {
        $errors[] = "Ultra Sound findings must be numeric.";
    }
    if (empty($fetalHeartRate) || !is_numeric($fetalHeartRate)) {
        $errors[] = "Fetal Heart Rate must be numeric.";
    }

    // Display errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>
                alert('" . SecurityUtils::sanitize_output($error) . "');
                window.location.href = 'Pregnancy_report1.html';  // Optional: redirect back to message page
            </script>";
        }
    } else {
        // Use prepared statement instead of direct variables
        $sql_query = "INSERT INTO pregnancy_report1 (report_Ic_Number, report_month, report_first_name, report_last_name, report_patient_tel, report_patient_birthday, report_patient_email, report_patient_address1, report_patient_address2, report_first_city, report_state, report_postal, bloodPressure, weight1, ultraSound, fetalHeartRate, maternalSymptoms, immunizations, doctorreport) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql_query);
        $stmt->bind_param("sssssssssssssssssss", 
            $report_Ic_Number, 
            $report_month,
            $report_first_name,
            $report_last_name,
            $report_patient_tel,
            $report_patient_birthday,
            $report_patient_email,
            $report_patient_address1,
            $report_patient_address2,
            $report_first_city,
            $report_state,
            $report_postal,
            $bloodPressure,
            $weight1,
            $ultraSound,
            $fetalHeartRate,
            $maternalSymptoms,
            $immunizations,
            $doctorreport
        );

        if ($stmt->execute()) {
            echo "<script>alert('Data inserted successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . SecurityUtils::sanitize_output($stmt->error) . "');</script>";
        }
    }
    mysqli_close($conn);
} elseif (isset($_POST['report_search_submit'])) {
    $report_IC_number = $_POST['report_IC_number'];
    $report_month = $_POST['report_month'];

    // Query to retrieve the report based on the IC number and month
    $query = "SELECT * FROM pregnancy_report1 WHERE report_Ic_Number = '$report_IC_number' AND report_month = '$report_month'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Extract the report details from the retrieved row
        $report_Ic_Number = $row['report_Ic_Number'];
        $report_month =  $row['report_month'];
        $reportFirstName = $row['report_first_name'];
        $reportLastName = $row['report_last_name'];
        $reportPatientTel = $row['report_patient_tel'];
        $report_patient_birthday = $row['report_patient_birthday'];
        $report_patient_email = $row['report_patient_email'];
        $report_patient_address1 = $row['report_patient_address1'];
        $report_patient_address2 = $row['report_patient_address2'];
        $report_first_city = $row['report_first_city'];
        $report_state = $row['report_state'];
        $report_postal = $row['report_postal'];
        $bloodPressure = $row['bloodPressure'];
        $weight1 = $row['weight1'];
        $ultraSound = $row['ultraSound'];
        $fetalHeartRate = $row['fetalHeartRate'];
        $maternalSymptoms = $row['maternalSymptoms'];
        $immunizations = $row['immunizations'];
        $doctorreport = $row['doctorreport'];

        echo '
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Klinik Kesihatan</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                <link rel="stylesheet" href="HomePage.css">
                <link rel="stylesheet" href="Pregnancy_reportFor_Php.css">
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
        <div class="transparent_button">
            <a href="ForAppointment.html" class="buttonItSlef details">BOOk APPOINTMENT</a>
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
        
        echo "<div class='bgcontainer'>";
        echo "<div class='container'>";
        echo "<div class='report_details'>";
        echo "<form>";
        echo "<label for='report_Ic_Number'>Ic Number:</label>";
        echo "<input type='text' id='report_Ic_Number' name='report_Ic_Number' value='$report_Ic_Number' readonly><br><br>";
        
        echo "<label for='report_month'>Pregnancy Month:</label>";
        echo "<input type='text' id='report_month' name='report_month' value='$report_month' readonly><br><br>";
        
        echo "<label for='reportFirstName'>First Name:</label>";
        echo "<input type='text' id='reportFirstName' name='reportFirstName' value='$reportFirstName' readonly><br><br>";
        
        echo "<label for='reportLastName'>Last Name:</label>";
        echo "<input type='text' id='reportLastName' name='reportLastName' value='$reportLastName' readonly><br><br>";
        
        echo "<label for='reportPatientTel'>Phone Number:</label>";
        echo "<input type='text' id='reportPatientTel' name='reportPatientTel' value='$reportPatientTel' readonly><br><br>";
        
        echo "<label for='report_patient_birthday'>Birthday:</label>";
        echo "<input type='text' id='report_patient_birthday' name='report_patient_birthday' value='$report_patient_birthday' readonly><br><br>";
        
        echo "<label for='report_patient_email'>Email:</label>";
        echo "<input type='text' id='report_patient_email' name='report_patient_email' value='$report_patient_email' readonly><br><br>";
        
        echo "<label for='report_patient_address1'>Address1:</label>";
        echo "<input type='text' id='report_patient_address1' name='report_patient_address1' value='$report_patient_address1' readonly><br><br>";
        
        echo "<label for='report_patient_address2'>Address2:</label>";
        echo "<input type='text' id='report_patient_address2' name='report_patient_address2' value='$report_patient_address2' readonly><br><br>";
        
        echo "<label for='report_first_city'>City:</label>";
        echo "<input type='text' id='report_first_city' name='report_first_city' value='$report_first_city' readonly><br><br>";
        
        echo "<label for='report_state'>State:</label>";
        echo "<input type='text' id='report_state' name='report_state' value='$report_state' readonly><br><br>";
        
        echo "<label for='report_postal'>Postal:</label>";
        echo "<input type='text' id='report_postal' name='report_postal' value='$report_postal' readonly><br><br>";
        
        echo "<label for='bloodPressure'>Blood Pressure:</label>";
        echo "<input type='text' id='bloodPressure' name='bloodPressure' value='$bloodPressure' readonly><br><br>";
        
        echo "<label for='weight1'>Weight:</label>";
        echo "<input type='text' id='weight1' name='weight1' value='$weight1' readonly><br><br>";
        
        echo "<label for='ultraSound'>Ultra Sound:</label>";
        echo "<input type='text' id='ultraSound' name='ultraSound' value='$ultraSound' readonly><br><br>";
        
        echo "<label for='fetalHeartRate'>Fetal Heart Rate:</label>";
        echo "<input type='text' id='fetalHeartRate' name='fetalHeartRate' value='$fetalHeartRate' readonly><br><br>";
        
        echo "<label for='nextAppointment'>Next Appointment:</label>";
        echo "<input type='text' id='nextAppointment' name='nextAppointment' value='$doctorreport' readonly><br><br>";
        
        echo "</form>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p>No report found for the given IC number and month of pregnancy.</p>";
    }
    echo "</body>";
    echo "</html>";
}
?>