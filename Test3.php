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

// Define AES-256 encryption settings
define('AES_KEY', 'your_32_character_key_here'); // Must be 32 characters for AES-256
define('AES_IV', 'your_16_character_iv'); // Must be 16 characters

function aes_encrypt($data, $key, $iv) {
    return openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
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

    // Validate IC length
    if (strlen($Sign_up_details_IC) != 12 || !ctype_digit($Sign_up_details_IC)) {
        die("Error: IC number must be exactly 12 digits.");
    }

    // Encrypt the IC number using AES-256
    $encrypted_IC = aes_encrypt($Sign_up_details_IC, AES_KEY, AES_IV);

    // Hash the password
    $hashed_password = password_hash($Sign_up_details_pass, PASSWORD_BCRYPT);

    // Prepare the SQL query using placeholders
    $sql_query = "INSERT INTO sign_up (sign_up_details_email, Sign_up_details_pass, sign_up_details_IC, sign_up_details_Name, Sign_up_details_PhoneNumber, sign_up_details_address1, sign_up_details_address2, sign_up_details_city, sign_up_details_State, sign_up_details_postal, Sign_up_details_firstAppointment) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = mysqli_prepare($conn, $sql_query)) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "sssssssssss", $Sign_up_details_email, $hashed_password, $encrypted_IC, $Sign_up_details_Name, $Sign_up_details_PhoneNumber, $Sign_up_details_address1, $Sign_up_details_address2, $Sign_up_details_city, $Sign_up_details_State, $Sign_up_details_postal, $Sign_up_details_firstAppointment);
        
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
