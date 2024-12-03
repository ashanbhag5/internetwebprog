<?php
class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        // Load environment variables from the .env file
        $env = parse_ini_file('.env');

        // Assign values to properties
        $this->host = $env['DBHOST'];
        $this->db_name = $env['DBNAME'];
        $this->username = $env['DBUSER'];
        $this->password = $env['DBPASS'];
    }

    // Method to establish and return a database connection
    public function connect()
    {
        $this->conn = null; // Initialize connection to null

        try {
            // Create a new PDO instance with connection parameters
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error reporting
        } catch (PDOException $e) {
            
            die("Database connection failed: " . $e->getMessage());
        }

        // Return the PDO connection object
        return $this->conn;
    }
}
