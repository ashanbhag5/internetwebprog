<?php
class Database {
    private $host = 'localhost';      // Your database host
    private $db_name = 'nfl_data';    // Your database name
    private $username = 'root';       // Your MySQL username
    private $password = '';           // Your MySQL password
    private $conn;

    // Method to establish and return a database connection
    public function connect() {
        $this->conn = null; // Initialize connection to null
        try {
            // Create a new PDO instance with connection parameters
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name};charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error reporting
        } catch (PDOException $e) {
            // Display a user-friendly error message
            die("Database connection failed: " . $e->getMessage());
        }

        // Return the PDO connection object
        return $this->conn;
    }
}
?>
