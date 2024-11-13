<?php
$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

// Create connection
$conn = mysqli_connect($server_name, $username, $password, $database_name);

// Check connection
if (!$conn) {
    // Error Handling: Connection error
    die("Connection Failed: " . mysqli_connect_error());
}

// Check if the login form is submitted
if (isset($_POST['login_form_submit'])) {
    // Validation: Check if email and password fields are set and not empty
    if (empty($_POST['Login_email']) || empty($_POST['Login_password'])) {
        echo "Please enter both email and password.";
    } else {
        // Validation: Check if email is in valid format
        $email = $_POST['Login_email'];
        $password = $_POST['Login_password'];
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
        } else {
            // Insecure query with no parameter binding
            $sql_query = "SELECT * FROM sign_up WHERE sign_up_details_email = '$email' AND sign_up_details_pass = '$password'";

            $result = mysqli_query($conn, $sql_query);

            // Error Handling: Check if query execution is successful
            if (!$result) {
                echo "Query Execution Failed: " . mysqli_error($conn);
            } else {
                // Error Handling: Check if login credentials are correct
                if (mysqli_num_rows($result) == 1) {
                    // Redirect to HomePage if login is successful
                    header("Location: HomePage.html");
                    exit();
                } else {
                    echo "Incorrect email or password.";
                }
            }
        }
    }
}

// Close the connection
mysqli_close($conn);
?>
