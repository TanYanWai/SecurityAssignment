<?php
$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

$conn = new mysqli($server_name, $username, $password, $database_name);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Use prepared statement to prevent SQL injection
$sql = "SELECT Sign_up_details_email FROM sign_up";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepared statement failed: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

$emails = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $emails[] = $row['Sign_up_details_email'];
  }
}

$stmt->close();
$conn->close();

header("Content-Type: application/json");
echo json_encode($emails);
?>
