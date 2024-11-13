<?php
require_once __DIR__ . '/includes/BruteForceProtection.php';
date_default_timezone_set("Asia/Kuala_Lumpur");

$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

// Create connection
$conn = mysqli_connect($server_name, $username, $password, $database_name);

// Check connection
if (!$conn) {
    echo "Connection Failed: " . mysqli_connect_error();
    exit();
}

// Initialize brute force protection
$bruteForce = new BruteForceProtection($conn);

// Check if the login form is submitted
if (isset($_POST['login_form_submit'])) {
    if (empty($_POST['Login_email']) || empty($_POST['Login_password'])) {
        echo "Please enter both email and password.";
    } else {
        if ($bruteForce->isIPBlocked()) {
            $remainingTime = $bruteForce->getRemainingLockoutTime();
            $minutes = floor($remainingTime / 60);
            $seconds = $remainingTime % 60;
            echo "Too many failed attempts. Please try again in {$minutes} minute(s) and {$seconds} seconds.";
            exit();
        }

        $email = filter_var($_POST['Login_email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['Login_password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
        } else {
            // Prepare the statement to retrieve the hashed password
            $sql_query = "SELECT sign_up_details_pass FROM sign_up WHERE sign_up_details_email = ?";
            $stmt = mysqli_prepare($conn, $sql_query);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                echo "Query Execution Failed: " . mysqli_error($conn);
            } else if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['sign_up_details_pass'];

                // Verify the entered password with the hashed password
                if (password_verify($password, $hashedPassword)) {
                    $bruteForce->recordLoginAttempt($email, true);
                    session_start();
                    $_SESSION['user_email'] = $email;
                    echo "HomePage.html"; // This will trigger the redirect
                } else {
                    $bruteForce->recordLoginAttempt($email, false);
                    $attemptsLeft = $bruteForce->getMaxAttempts() - $bruteForce->getFailedAttempts($email);
                    echo "Incorrect email or password. Attempts remaining: {$attemptsLeft}";
                }
            } else {
                $bruteForce->recordLoginAttempt($email, false);
                $attemptsLeft = $bruteForce->getMaxAttempts() - $bruteForce->getFailedAttempts($email);
                echo "Incorrect email or password. Attempts remaining: {$attemptsLeft}";
            }
        }

        mysqli_stmt_close($stmt);
    }

    exit();
}

mysqli_close($conn);
?>
