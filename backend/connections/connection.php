<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todoApp";

// Create connection without specifying database
$conn = new mysqli($servername, $username, $password);

// Create database if it doesn't exist
$newDb = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($newDb) === FALSE) {
    echo "";
}

$conn->select_db($dbname);
?>