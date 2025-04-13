<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'recipe_website';

try {
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname 
            CHARACTER SET utf8mb4 
            COLLATE utf8mb4_unicode_ci";
    
    if ($conn->query($sql) === TRUE) {
        echo "Database '$dbname' created successfully!<br>";
        echo "Next step: Run create_tables.php to set up the tables.<br>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>