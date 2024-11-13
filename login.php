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

    // Insecure query with no parameter binding
    $sql_query = "SELECT * FROM sign_up WHERE sign_up_details_email = '$email' AND sign_up_details_pass = '$password'";

    $result = mysqli_query($conn, $sql_query);

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
}

// Close the connection
mysqli_close($conn);
?>
