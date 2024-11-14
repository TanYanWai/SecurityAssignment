<!DOCTYPE html>
<html lang="en">
<head> 
    <title>Hospital Booking System Appointment Form</title>
    <link rel="stylesheet" type="text/css" href="Pregnancy_report.css">
</head>

<body>
    <?php
    // Check if the form has been submitted
    if (isset($_POST['report_search_submit'])) {
        // Retrieve form data from the POST request
        $report_IC_number = $_POST['report_IC_number'];
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

        try {
            // Establish a secure database connection using PDO
            $pdo = new PDO("mysql:host=localhost;dbname=Assignment", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare a statement to insert data securely
            $stmt = $pdo->prepare("INSERT INTO reports (
                report_IC_number, report_month, report_first_name, report_last_name, 
                report_patient_tel, report_patient_birthday, report_patient_email, 
                report_patient_address1, report_patient_address2, report_first_city, 
                report_state, report_postal, bloodPressure, weight1, ultraSound, 
                fetalHeartRate, maternalSymptoms, immunizations, doctorreport
            ) VALUES (
                :report_IC_number, :report_month, :report_first_name, :report_last_name, 
                :report_patient_tel, :report_patient_birthday, :report_patient_email, 
                :report_patient_address1, :report_patient_address2, :report_first_city, 
                :report_state, :report_postal, :bloodPressure, :weight1, :ultraSound, 
                :fetalHeartRate, :maternalSymptoms, :immunizations, :doctorreport
            )");

            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':report_IC_number', $report_IC_number);
            $stmt->bindParam(':report_month', $report_month);
            $stmt->bindParam(':report_first_name', $report_first_name);
            $stmt->bindParam(':report_last_name', $report_last_name);
            $stmt->bindParam(':report_patient_tel', $report_patient_tel);
            $stmt->bindParam(':report_patient_birthday', $report_patient_birthday);
            $stmt->bindParam(':report_patient_email', $report_patient_email);
            $stmt->bindParam(':report_patient_address1', $report_patient_address1);
            $stmt->bindParam(':report_patient_address2', $report_patient_address2);
            $stmt->bindParam(':report_first_city', $report_first_city);
            $stmt->bindParam(':report_state', $report_state);
            $stmt->bindParam(':report_postal', $report_postal);
            $stmt->bindParam(':bloodPressure', $bloodPressure);
            $stmt->bindParam(':weight1', $weight1);
            $stmt->bindParam(':ultraSound', $ultraSound);
            $stmt->bindParam(':fetalHeartRate', $fetalHeartRate);
            $stmt->bindParam(':maternalSymptoms', $maternalSymptoms);
            $stmt->bindParam(':immunizations', $immunizations);
            $stmt->bindParam(':doctorreport', $doctorreport);

            // Execute the statement
            $stmt->execute();
            echo "Report has been saved successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
    
    <header class="header">
        <!-- Your header content goes here -->
    </header>
    
    <div class="report_bg"></div>
    <div class="report_container">
        <div class="report_title_patient">
            <h1>Pregnancy Report</h1>
        </div>
        <div class="report_search">
            <!-- Your search form goes here -->
        </div>

        <form action="Pregnancy_report.php" method="post">
            <div class="report_welcome_patient">
                <h3>Report details</h3>
            </div>
            <div class="report_details">
                <label for="report_IC">IC number:</label><br>
                <input type="text" name="report_IC_number" placeholder="IC Number" maxlength="30" value="<?php echo htmlspecialchars($report_IC_number); ?>">
            </div>
            <div class="report_details">
                <label for="report_month">Pregnancy Month:</label><br>
                <select name="report_month">
                    <!-- Your options go here -->
                </select>
            </div>
            <div class="report_details hidden_page">
                <label for="report_name">Name:</label><br>
                <input type="text" name="report_first_name" placeholder="First Name" maxlength="10" value="<?php echo htmlspecialchars($report_first_name); ?>">
                <input type="text" name="report_last_name" placeholder="Last Name" maxlength="10" value="<?php echo htmlspecialchars($report_last_name); ?>">
            </div>
            <!-- Rest of the form fields go here -->
            <div class="button_container">
                <input id="showMoreButton" class="RegisterButton" type="button" name="report_button1" value="Create Report">
                <input id="RegisterButton2" class="RegisterButton" type="submit" name="report_search_submit" value="Save">
            </div>
        </form>
    </div>

    <script type="text/javascript" src="Pregnancy_report.js"></script>
</body>
</html> 
