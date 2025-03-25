<?php
$host = 'localhost';
$user = 'root';  // Change to your MySQL username
$pass = '';      // Change to your MySQL password
$dbname = 'cts_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
