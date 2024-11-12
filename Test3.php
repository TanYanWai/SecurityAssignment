<?php
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

if (isset($_POST['save_sign_up'])) {
    // Get the form data
    $Sign_up_details_email = $_POST['Sign_up_details_email'];
    $Sign_up_details_pass = $_POST['Sign_up_details_pass'];
    $Sign_up_details_IC = $_POST['Sign_up_details_IC'];
    $Sign_up_details_Name = $_POST['Sign_up_details_Name'];
    $Sign_up_details_PhoneNumber = $_POST['Sign_up_details_PhoneNumber'];
    $Sign_up_details_address1 = $_POST['Sign_up_details_address1'];
    $Sign_up_details_address2 = $_POST['Sign_up_details_address2'];
    $Sign_up_details_city = $_POST['Sign_up_details_city'];
    $Sign_up_details_State = $_POST['Sign_up_details_State'];
    $Sign_up_details_postal = $_POST['Sign_up_details_postal'];
    $Sign_up_details_firstAppointment = $_POST['Sign_up_details_firstAppointment'];

    // Prepare the SQL query using placeholders
    $sql_query = "INSERT INTO sign_up (sign_up_details_email, Sign_up_details_pass, sign_up_details_IC, sign_up_details_Name, Sign_up_details_PhoneNumber, sign_up_details_address1, sign_up_details_address2, sign_up_details_city, sign_up_details_State, sign_up_details_postal, Sign_up_details_firstAppointment) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = mysqli_prepare($conn, $sql_query)) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "sssssssssss", $Sign_up_details_email, $Sign_up_details_pass, $Sign_up_details_IC, $Sign_up_details_Name, $Sign_up_details_PhoneNumber, $Sign_up_details_address1, $Sign_up_details_address2, $Sign_up_details_city, $Sign_up_details_State, $Sign_up_details_postal, $Sign_up_details_firstAppointment);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Data inserted successfully, redirect to login1.html
            header("Location: login1.html");
            exit; // Terminate the current script to ensure the redirect happens
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        
        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
} else {
    echo "Form not submitted";
}
?>
