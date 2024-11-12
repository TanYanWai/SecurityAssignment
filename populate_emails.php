<?php
$server_name = "localhost";
$username = "root";
$password = "";
$database_name = "assignment";

$conn = new mysqli($server_name, $username, $password, $database_name);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Sign_up_details_email FROM sign_up";
$result = $conn->query($sql);

$emails = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $emails[] = $row['Sign_up_details_email'];
  }
}

$conn->close();

header("Content-Type: application/json");
echo json_encode($emails);
?>