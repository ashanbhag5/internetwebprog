<?php
require_once 'Database.php'; // Include the Database class

$db = new Database(); // Instantiate the Database class
$conn = $db->connect(); // Attempt to connect

if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Failed to connect to the database.";
}
?>
