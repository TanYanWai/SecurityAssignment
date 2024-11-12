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

// Check if the login form is submitted
if (isset($_POST['login_form_submit'])) {
    $email = $_POST['Login_email'];
    $password = $_POST['Login_password'];

    // Use prepared statement to prevent SQL injection
    $sql_query = "SELECT * FROM sign_up WHERE sign_up_details_email = ? AND sign_up_details_pass = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql_query);
    
    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "ss", $email, $password); // 'ss' means both parameters are strings
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            // Redirect to HomePage if login is successful
            header("Location: HomePage.html");
            exit();
        } else {
            echo "Incorrect email or password.";
        }
    } else {
        echo "Query Execution Failed: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>
