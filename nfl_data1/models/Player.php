<?php
class Player {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPlayerStats($playerName) {
        $query = "SELECT * FROM player_stats WHERE player_display_name = :playerName ORDER BY week ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':playerName', $playerName);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return result as associative array
    }
}
?>
