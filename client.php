<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT room_number, queue_number FROM queue_table WHERE is_current = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentRoom = $row["room_number"];
    $currentQueue = $row["queue_number"];
} else {
    $currentRoom = "N/A";
    $currentQueue = "N/A";
}

// Fetch the queue numbers
$queueNumbers = [];
$sql = "SELECT room_number, queue_number FROM queue_table";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $queueNumbers[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Page</title>
    <style>
        .room-container {
            margin-bottom: 20px;
        }

        .room-number {
            font-weight: bold;
        }

        .queue-number {
            margin-left: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to periodically refresh the page
        function refreshPage() {
            location.reload();
        }

        // Refresh the page every 5 seconds
        setInterval(refreshPage, 5000);
    </script>
</head>
<body>
    <div class="room-container">
        <span class="room-number">Current Room:</span>
        <span class="queue-number"><?php echo $currentRoom; ?></span>
    </div>

    <div class="room-container">
        <span class="room-number">Queue Numbers:</span>
        <?php
        if (count($queueNumbers) > 0) {
            foreach ($queueNumbers as $queue) {
                $room = $queue["room_number"];
                $queueNumber = $queue["queue_number"];
                echo '<div><span class="room-number">' . $room . ':</span> <span class="queue-number">' . $queueNumber . '</span></div>';
            }
        } else {
            echo "No rooms in the queue.";
        }
        ?>
    </div>

</body>
</html>