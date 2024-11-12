<?php
$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "Assignment";

$conn = mysqli_connect($server_name, $username, $password, $database_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['login_form_submit'])) {
    $email = $_POST['Login_email'];
    $password = $_POST['Login_password'];

    $sql_query = "SELECT * FROM sign_up WHERE sign_up_details_email = ? AND sign_up_details_pass = ?";

    $stmt = mysqli_prepare($conn, $sql_query);

    if (!$stmt) {
        die("Query Preparation Failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            header("Location: HomePage.html");
            exit();
        } else {
            echo "Incorrect email or password.";
        }
    } else {
        echo "Query Execution Failed: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>