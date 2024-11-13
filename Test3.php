<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

// Create connection
$conn = mysqli_connect($server_name, $username, $password, $database_name);

// Error Handling: Check connection
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['save_sign_up'])) {
    // Retrieve form data
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

    // Validation: Check if required fields are filled in
    if (empty($Sign_up_details_email) || empty($Sign_up_details_pass) || empty($Sign_up_details_IC) ||
        empty($Sign_up_details_Name) || empty($Sign_up_details_PhoneNumber) || empty($Sign_up_details_address1) ||
        empty($Sign_up_details_city) || empty($Sign_up_details_State) || empty($Sign_up_details_postal) ||
        empty($Sign_up_details_firstAppointment)) {
        die("All fields are required. Please fill in all the fields.");
    }

    // Validation: Check if email is in a valid format
    if (!filter_var($Sign_up_details_email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Validation: Check password strength
    if (strlen($Sign_up_details_pass) < 8 ||
        !preg_match('/[A-Z]/', $Sign_up_details_pass) ||    // At least one uppercase letter
        !preg_match('/[a-z]/', $Sign_up_details_pass) ||    // At least one lowercase letter
        !preg_match('/[0-9]/', $Sign_up_details_pass) ||    // At least one number
        !preg_match('/[\W]/', $Sign_up_details_pass)) {     // At least one special character
        die("Password must be at least 8 characters long, with at least one uppercase letter, one lowercase letter, one digit, and one special character.");
    }

    // Validation: Check phone number format (exactly 10 digits)
    if (!preg_match('/^[0-9]{10}$/', $Sign_up_details_PhoneNumber)) {
        die("Phone number must be exactly 10 digits.");
    }

    // Validation: Check postal code format (exactly 5 digits)
    if (!preg_match('/^[0-9]{5}$/', $Sign_up_details_postal)) {
        die("Postal code must be exactly 5 digits.");
    }

    // Insert data into the database
    $sql_query = "INSERT INTO sign_up (sign_up_details_email, Sign_up_details_pass, sign_up_details_IC, sign_up_details_Name, Sign_up_details_PhoneNumber, sign_up_details_address1, sign_up_details_address2, sign_up_details_city, sign_up_details_State, sign_up_details_postal, Sign_up_details_firstAppointment) 
    VALUES ('$Sign_up_details_email','$Sign_up_details_pass','$Sign_up_details_IC','$Sign_up_details_Name','$Sign_up_details_PhoneNumber','$Sign_up_details_address1','$Sign_up_details_address2','$Sign_up_details_city','$Sign_up_details_State','$Sign_up_details_postal','$Sign_up_details_firstAppointment')";

    // Error Handling: Check if query executes successfully
    if (mysqli_query($conn, $sql_query)) {
        // Data inserted successfully, redirect to login1.html
        header("Location: login1.html");
        exit; // Terminate the current script to ensure the redirect happens
    } else {
        // Error Handling: Output detailed error if query fails
        echo "Error: " . $sql_query . "<br>" . mysqli_error($conn);
    }
    
    // Close the connection
    mysqli_close($conn);
} else {
    echo "Form not submitted";
}
?>
