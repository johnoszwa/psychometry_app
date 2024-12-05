<?php
include 'db_connection.php';

if ($conn) {
    echo "Connection successful!";
} else {
    echo "Connection failed: " . $conn->connect_error;
}

$conn->close();
?>
