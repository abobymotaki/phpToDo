<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todoApp";

// Create connection with the port specified
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$newDb = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($newDb) === FALSE) {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($dbname);
?>