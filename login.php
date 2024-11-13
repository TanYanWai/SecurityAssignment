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
    die("Connection Failed: " . mysqli_connect_error());
}


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
    $email = $_POST['Login_email'];
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
    // Define the log file path (ensure correct path)
    $log_file = __DIR__ . "/logs/user_activity.log";
    $current_time = date("Y-m-d H:i:s");
    $log_message = "User with email $email attempted to log in at $current_time\n";

    // Ensure the logs directory exists
    if (!file_exists(__DIR__ . "/logs")) {
        mkdir(__DIR__ . "/logs", 0777, true);  // Create 'logs' directory if not exists
    }

    // Log the login attempt (write to the log file)
    if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
        echo "Error logging login attempt! Could not write to log file.";
    }

    // Use prepared statements for secure query
    $stmt = $conn->prepare("SELECT * FROM sign_up WHERE sign_up_details_email = ? AND sign_up_details_pass = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            // Log successful login
            $log_message = "User with email $email successfully logged in at $current_time\n";
            if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
                echo "Error logging successful login!";
            }

            // Return 'HomePage.html' for redirection
            echo 'HomePage.html';
        } else {
            // Log failed login attempt
            $log_message = "Failed login attempt for email $email at $current_time (Incorrect email or password)\n";
            if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
                echo "Error logging failed login attempt!";
            }

            // Return error response
            echo 'Incorrect email or password';
        }
    } else {
        // Log query execution error
        $log_message = "Login query failed for email $email at $current_time. Error: " . mysqli_error($conn) . "\n";
        if (file_put_contents($log_file, $log_message, FILE_APPEND) === false) {
            echo "Error logging query execution failure!";
        }

        // Return query failure message
        echo 'Login query failed. Please try again later.';
    }

    // Close the prepared statement
    $stmt->close();
}

mysqli_close($conn);
?>
