<?php
// Database connection details
$host = "localhost";      // Your database host
$username = "root";       // Your MySQL username
$password = "";           // Your MySQL password (leave blank if none)
$database = "cts_db";     // Your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
} else {
    echo "✅ Successfully connected to the database!";
}

// Close connection
$conn->close();
?>
