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

// Add a decryption function
function aes_decrypt($data, $key, $iv) {
    return openssl_decrypt($data, 'AES-256-CBC', $key, 0, $iv);
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

    // Encrypt the fields using AES-256
    $encrypted_IC = aes_encrypt($Sign_up_details_IC, AES_KEY, AES_IV);
    $encrypted_PhoneNumber = aes_encrypt($Sign_up_details_PhoneNumber, AES_KEY, AES_IV);
    $encrypted_address1 = aes_encrypt($Sign_up_details_address1, AES_KEY, AES_IV);
    $encrypted_address2 = aes_encrypt($Sign_up_details_address2, AES_KEY, AES_IV);
    $encrypted_city = aes_encrypt($Sign_up_details_city, AES_KEY, AES_IV);
    $encrypted_State = aes_encrypt($Sign_up_details_State, AES_KEY, AES_IV);
    $encrypted_postal = aes_encrypt($Sign_up_details_postal, AES_KEY, AES_IV);

    // Hash the password
    $hashed_password = password_hash($Sign_up_details_pass, PASSWORD_BCRYPT);

    // Prepare the SQL query using placeholders
    $sql_query = "INSERT INTO sign_up (sign_up_details_email, Sign_up_details_pass, sign_up_details_IC, sign_up_details_Name, sign_up_details_PhoneNumber, sign_up_details_address1, sign_up_details_address2, sign_up_details_city, sign_up_details_State, sign_up_details_postal, Sign_up_details_firstAppointment) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
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
