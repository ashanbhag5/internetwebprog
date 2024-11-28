<?php
class Player {
    private $conn;
    private $table = 'player_stats'; // Replace with your table name

    public function __construct($db) {
        $this->conn = $db;
    }

    // Function to fetch player stats by name
    public function getPlayerFantasyPoints($playerName) {
        $query = "
            SELECT 
                week, fantasy_points 
            FROM 
                {$this->table}
            WHERE 
                player_display_name = :player_name
            ORDER BY 
                week ASC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':player_name', $playerName);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
