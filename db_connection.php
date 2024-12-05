<?php
$host = 'localhost';
$username = 'root'; // Update if different
$password = ''; // Update if different
$dbname = 'psychometry_db';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
