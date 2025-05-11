<?php 
include_once "connection.php";

// Create Users Table
$create_user_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

// Create Task Lists Table
$create_task_list_table = "CREATE TABLE IF NOT EXISTS task_lists (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    list_name VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

// Create Tasks Table
$create_task_table = "CREATE TABLE IF NOT EXISTS tasks (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    task VARCHAR(255) NOT NULL,
    taskListID INT(11) NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (taskListID) REFERENCES task_lists(id) ON DELETE CASCADE
)";

// Execute queries in correct order with error handling
if (!$conn->query($create_user_table)) {
    echo "Error creating users table: " . $conn->error;
}

if (!$conn->query($create_task_list_table)) {
    echo "Error creating task_lists table: " . $conn->error;
}

if (!$conn->query($create_task_table)) {
    echo "Error creating tasks table: " . $conn->error;
}
?>