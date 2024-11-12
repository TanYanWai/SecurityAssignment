<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "assignment";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
update_queue.php :
<?php
include 'config.php';

$sql = "UPDATE queue1 SET number = number + 1";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Success";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
get_queue_number.php:
<?php
include 'config.php';

$sql = "SELECT number FROM queue";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo $row['number'];
} else {
    echo "0";
}

mysqli_close($conn);
?>
