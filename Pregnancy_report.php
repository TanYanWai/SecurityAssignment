<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

// Establish database connection
$conn = mysqli_connect($server_name, $username, $password, $database_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

function logUserActivity($action, $icNumber, $month = null) {
    $logFile = 'logs/user_activity.log';  // Make sure the 'logs' directory exists
    $timestamp = date("Y-m-d H:i:s");
    $logMessage = "[$timestamp] Action: $action | IC Number: $icNumber";

    if ($month) {
        $logMessage .= " | Month: $month";
    }

    // Log the activity to the file
    file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
}

if (isset($_POST['report_button'])) {
    // Capture form data
    $report_Ic_Number = $_POST['report_Ic_Number'];
    $report_month = $_POST['report_month'];
    $report_first_name = $_POST['report_first_name'];
    $report_last_name = $_POST['report_last_name'];
    $report_patient_tel = $_POST['report_patient_tel'];
    $report_patient_birthday = $_POST['report_patient_birthday'];
    $report_patient_email = $_POST['report_patient_email'];
    $report_patient_address1 = $_POST['report_patient_address1'];
    $report_patient_address2 = $_POST['report_patient_address2'];
    $report_first_city = $_POST['report_first_city'];
    $report_state = $_POST['report_state'];
    $report_postal = $_POST['report_postal'];
    $bloodPressure = $_POST['bloodPressure'];
    $weight1 = $_POST['weight1'];
    $ultraSound = $_POST['ultraSound'];
    $fetalHeartRate = $_POST['fetalHeartRate'];
    $maternalSymptoms = $_POST['maternalSymptoms'];
    $immunizations = $_POST['immunizations'];
    $doctorreport = $_POST['doctorreport'];

    // Prepare SQL query
    $sql_query = "INSERT INTO pregnancy_report1 (report_Ic_Number, report_month, report_first_name, report_last_name, 
                    report_patient_tel, report_patient_birthday, report_patient_email, report_patient_address1, 
                    report_patient_address2, report_first_city, report_state, report_postal, bloodPressure, 
                    weight1, ultraSound, fetalHeartRate, maternalSymptoms, immunizations, doctorreport)
                  VALUES ('$report_Ic_Number', '$report_month', '$report_first_name', '$report_last_name', 
                          '$report_patient_tel', '$report_patient_birthday', '$report_patient_email', 
                          '$report_patient_address1', '$report_patient_address2', '$report_first_city', 
                          '$report_state', '$report_postal', '$bloodPressure', '$weight1', '$ultraSound', 
                          '$fetalHeartRate', '$maternalSymptoms', '$immunizations', '$doctorreport')";

    // Execute SQL query
    if (mysqli_query($conn, $sql_query)) {
        echo "Data inserted successfully!";
        logUserActivity('Insert Report', $report_Ic_Number, $report_month);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
} elseif (isset($_POST['report_search_submit'])) {
    // Retrieve report based on IC number and month
    $report_IC_number = $_POST['report_IC_number'];
    $report_month = $_POST['report_month'];

    // Query to retrieve the report
    $query = "SELECT * FROM pregnancy_report1 WHERE report_Ic_Number = '$report_IC_number' AND report_month = '$report_month'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Extract the report details
        $report_Ic_Number = $row['report_Ic_Number'];
        $report_month = $row['report_month'];
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

        // Display the retrieved report details
        echo '
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Klinik Kesihatan</title>
            <link rel="stylesheet" href="HomePage.css">
            <link rel="stylesheet" href="Pregnancy_reportFor_Php.css">
        </head>
        <body>
        <header class="header">
            <div class="top_header">
                <div class="contacts">
                    <div class="contact_email">
                        <span>CKlinik@gamil.com</span>
                    </div>
                    <div class="contact_phone">
                        <span>+604 222 2222</span>
                    </div>
                </div>
                <div class="transparent_button">
                    <a href="ForAppointment.html" class="buttonItSlef details">BOOK APPOINTMENT</a>
                </div>
            </div>
            <div class="navigation">
                <div class="brand">
                    <a href="#" class="logo"><i class="fas fa-heartbeat"></i><b> Island Pregnancy Clinic</b></a>
                </div>
                <div class="nav">
                    <a href="HomePage.html">Home</a>
                    <a href="LiveQueue.html">Live Queue</a>
                    <a href="Message.html">Send Message</a>
                    <a href="output_message.php">Receive Message</a>
                    <a href="Pregnancy_report1.html">Report</a>
                </div>
            </div>
        </header>
        <div class="bgcontainer">
            <div class="container">
                <div class="report_details">
                    <form>
                        <label for="report_Ic_Number">IC Number:</label>
                        <input type="text" id="report_Ic_Number" name="report_Ic_Number" value="$report_Ic_Number" readonly><br><br>
                        <!-- Add other form fields here for displaying the retrieved report -->
                        <label for="report_first_name">First Name:</label>
                        <input type="text" id="report_first_name" name="report_first_name" value="$reportFirstName" readonly><br><br>
                    </form>
                </div>
            </div>
        </div>
        </body>
        </html>';

        logUserActivity('Search Report', $report_IC_number, $report_month);
    } else {
        echo "<p>No report found for the given IC number and month of pregnancy.</p>";
    }
    mysqli_close($conn);
}
?>
