<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://unpkg.com; style-src 'self' 'unsafe-inline' https://unpkg.com;");

require_once 'includes/SecurityUtils.php';
require_once 'includes/config.php';

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

// Generate a random 32-byte key for AES-256 (64 hex characters)
define('AES_KEY', bin2hex(openssl_random_pseudo_bytes(32))); // 32 bytes, 64 hex characters

// Generate a random 16-byte IV (32 hex characters)
define('AES_IV', bin2hex(openssl_random_pseudo_bytes(16))); // 16 bytes, 32 hex characters

// Encrypt function
function aes_encrypt($data, $key, $iv) {
    return openssl_encrypt($data, 'AES-256-CBC', hex2bin($key), 0, hex2bin($iv));
}

// Decrypt function
function aes_decrypt($data, $key, $iv) {
    return openssl_decrypt($data, 'AES-256-CBC', hex2bin($key), 0, hex2bin($iv));
}

if (isset($_POST['save_sign_up'])) {
    // Retrieve form data
    $Sign_up_details_email = SecurityUtils::sanitize_input($_POST['Sign_up_details_email']);
    $Sign_up_details_pass = SecurityUtils::sanitize_input($_POST['Sign_up_details_pass']);
    $Sign_up_details_IC = SecurityUtils::sanitize_input($_POST['Sign_up_details_IC']);
    $Sign_up_details_Name = SecurityUtils::sanitize_input($_POST['Sign_up_details_Name']);
    $Sign_up_details_PhoneNumber = SecurityUtils::sanitize_input($_POST['Sign_up_details_PhoneNumber']);
    $Sign_up_details_address1 = SecurityUtils::sanitize_input($_POST['Sign_up_details_address1']);
    $Sign_up_details_address2 = SecurityUtils::sanitize_input($_POST['Sign_up_details_address2']);
    $Sign_up_details_city = SecurityUtils::sanitize_input($_POST['Sign_up_details_city']);
    $Sign_up_details_State = SecurityUtils::sanitize_input($_POST['Sign_up_details_State']);
    $Sign_up_details_postal = SecurityUtils::sanitize_input($_POST['Sign_up_details_postal']);
    $Sign_up_details_firstAppointment = SecurityUtils::sanitize_input($_POST['Sign_up_details_firstAppointment']);

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

    // Validate IC length
    if (strlen($Sign_up_details_IC) != 12 || !ctype_digit($Sign_up_details_IC)) {
        die("Error: IC number must be exactly 12 digits.");
    }

    // Encrypt the fields using AES-256
    $encrypted_IC = aes_encrypt($Sign_up_details_IC, ENCRYPTION_KEY, ENCRYPTION_IV);
    $encrypted_PhoneNumber = aes_encrypt($Sign_up_details_PhoneNumber, ENCRYPTION_KEY, ENCRYPTION_IV);
    $encrypted_address1 = aes_encrypt($Sign_up_details_address1, ENCRYPTION_KEY, ENCRYPTION_IV);
    $encrypted_address2 = aes_encrypt($Sign_up_details_address2, ENCRYPTION_KEY, ENCRYPTION_IV);
    $encrypted_city = aes_encrypt($Sign_up_details_city, ENCRYPTION_KEY, ENCRYPTION_IV);
    $encrypted_State = aes_encrypt($Sign_up_details_State, ENCRYPTION_KEY, ENCRYPTION_IV);
    $encrypted_postal = aes_encrypt($Sign_up_details_postal, ENCRYPTION_KEY, ENCRYPTION_IV);

    // Hash the password
    $hashed_password = password_hash($Sign_up_details_pass, PASSWORD_BCRYPT);

    // Prepare the SQL query using placeholders
    $sql_query = "INSERT INTO sign_up (sign_up_details_email, Sign_up_details_pass, sign_up_details_IC, sign_up_details_Name, sign_up_details_PhoneNumber, sign_up_details_address1, sign_up_details_address2, sign_up_details_city, sign_up_details_State, sign_up_details_postal, Sign_up_details_firstAppointment) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Error Handling: Check if query executes successfully
    if ($stmt = mysqli_prepare($conn, $sql_query)) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "sssssssssss", $Sign_up_details_email, $hashed_password, $encrypted_IC, $Sign_up_details_Name, $encrypted_PhoneNumber, $encrypted_address1, $encrypted_address2, $encrypted_city, $encrypted_State, $encrypted_postal, $Sign_up_details_firstAppointment);

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

// Example of fetching and decrypting data
$sql_query = "SELECT sign_up_details_IC, sign_up_details_PhoneNumber FROM sign_up WHERE sign_up_details_email = ?";
if ($stmt = mysqli_prepare($conn, $sql_query)) {
    mysqli_stmt_bind_param($stmt, "s", $Sign_up_details_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $encrypted_IC, $encrypted_PhoneNumber);

    if (mysqli_stmt_fetch($stmt)) {
        // Decrypt the retrieved data
        $decrypted_IC = aes_decrypt($encrypted_IC, AES_KEY, AES_IV);
        $decrypted_PhoneNumber = aes_decrypt($encrypted_PhoneNumber, AES_KEY, AES_IV);

        echo "Decrypted IC: " . $decrypted_IC . "<br>";
        echo "Decrypted Phone Number: " . $decrypted_PhoneNumber . "<br>";
    } else {
        echo "No record found.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>
