<?php
$host = "localhost:3308"; // Replace with your database host
$dbUsername = "root"; // Replace with your database username
$dbPassword = ""; // Replace with your database password
$dbName = "scrapster"; // Replace with your database name

// Create a database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>