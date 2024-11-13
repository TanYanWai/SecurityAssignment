<?php
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

// Log file path
$log_file = __DIR__ . "/logs/user_activity.log";  // Correct log path
$current_time = date("Y-m-d H:i:s");

// Log the attempt
$log_message = "Login attempt at $current_time\n";
file_put_contents($log_file, $log_message, FILE_APPEND);

// Check if the login form is submitted
if (isset($_POST['login_form_submit'])) {
    $email = $_POST['Login_email'];
    $password = $_POST['Login_password'];

    // Log the form submission
    $log_message = "Login form submitted at $current_time with email: $email\n";
    file_put_contents($log_file, $log_message, FILE_APPEND);

    // Insecure query with no parameter binding (for demonstration purposes; needs improvement for security)
    $sql_query = "SELECT * FROM sign_up WHERE sign_up_details_email = '$email' AND sign_up_details_pass = '$password'";

    $result = mysqli_query($conn, $sql_query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            // Log successful login
            $log_message = "User with email $email successfully logged in at $current_time\n";
            file_put_contents($log_file, $log_message, FILE_APPEND);

            // Redirect to HomePage if login is successful
            header("Location: HomePage.html");
            exit();
        } else {
            // Log failed login attempt
            $log_message = "Failed login attempt for email $email at $current_time (Incorrect email or password)\n";
            file_put_contents($log_file, $log_message, FILE_APPEND);
        }
    } else {
        // Log query execution error
        $log_message = "Login query failed for email $email at $current_time. Error: " . mysqli_error($conn) . "\n";
        file_put_contents($log_file, $log_message, FILE_APPEND);
    }
}

// Close the connection
mysqli_close($conn);
?>
