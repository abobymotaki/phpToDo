<?php


// Create connection with the port specified
$conn = new mysqli($servername, $username, $password, "", $port);

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

$tablesResult = $conn->query("SHOW TABLES");
if ($tablesResult->num_rows > 0) {
    while ($tableRow = $tablesResult->fetch_array()) {
        $tableName = $tableRow[0];
        echo "<h2>Table: $tableName</h2>";
        
        // Get all fields of the table
        $fieldsResult = $conn->query("DESCRIBE $tableName");
        echo "<h3>Fields:</h3><ul>";
        while ($fieldRow = $fieldsResult->fetch_assoc()) {
            echo "<li>{$fieldRow['Field']} - {$fieldRow['Type']}</li>";
        }
        echo "</ul>";
        
        // Get all data from the table
        $dataResult = $conn->query("SELECT * FROM $tableName");
        if ($dataResult->num_rows > 0) {
            echo "<h3>Data:</h3><table border='1'><tr>";
            
            // Print column headers
            while ($fieldInfo = $dataResult->fetch_field()) {
                echo "<th>{$fieldInfo->name}</th>";
            }
            echo "</tr>";
            
            // Print table rows
            while ($dataRow = $dataResult->fetch_assoc()) {
                echo "<tr>";
                foreach ($dataRow as $cell) {
                    echo "<td>$cell</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No data found.</p>";
        }
    }
} else {
    echo "<p>No tables found in the database.</p>";
}

?>