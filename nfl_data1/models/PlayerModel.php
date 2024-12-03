<?php
class PlayerModel
{
    private $db;

    // Team mapping for fallback if database mapping is unavailable
    private $teamMapping = [
        'CHI' => 'Chicago',
        'DET' => 'Detroit',
        'NYG' => 'N.Y. Giants',
        'DAL' => 'Dallas',
        'MIA' => 'Miami',
        'GB'  => 'Green Bay',
        'LV'  => 'Las Vegas',
        'KC'  => 'Kansas City',
        'BUF' => 'Buffalo',
        'PIT' => 'Pittsburgh',
        'CIN' => 'Cincinnati',
        'HOU' => 'Houston',
        'JAX' => 'Jacksonville',
        'ARI' => 'Arizona',
        'MIN' => 'Minnesota',
        'IND' => 'Indianapolis',
        'NE'  => 'New England',
        'SEA' => 'Seattle',
        'NYJ' => 'N.Y. Jets',
        'TEN' => 'Tennessee',
        'WAS' => 'Washington',
        'TB'  => 'Tampa Bay',
        'CAR' => 'Carolina',
        'LA' => 'L.A. Rams',
        'NO'  => 'New Orleans',
        'PHI' => 'Philadelphia',
        'BAL' => 'Baltimore',
        'ATL' => 'Atlanta',
        'SF'  => 'San Francisco',
        'LAC' => 'L.A. Chargers',
        'CLE' => 'Cleveland',
        'DEN' => 'Denver',
    ];

    // Constructor to initialize the database connection
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Method to get player names for autocomplete based on the search query
    public function getPlayerNames($query)
    {
        $query = "%" . $query . "%";
        $sql = "SELECT DISTINCT player_display_name FROM player_stats WHERE player_display_name LIKE :query LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':query', $query, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get a player's fantasy points data, including the headshot URL for the selected player
    public function getPlayerData($playerName)
    {
        $sql = "SELECT season, player_id, week, recent_team, opponent_team, position, fantasy_points, headshot_url, player_display_name 
                FROM player_stats WHERE player_display_name = :player_name 
                ORDER BY season ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Method to get matchups for a specific season and week
    public function getMatchup($team, $week)
    {
        $query = "
            SELECT 
                CASE 
                    WHEN team_1 = :team THEN team_2 
                    WHEN team_2 = :team THEN team_1 
                END AS opponent
            FROM matchups 
            WHERE (team_1 = :team OR team_2 = :team) AND week = :week";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':team', $team, PDO::PARAM_STR);
        $stmt->bindParam(':week', $week, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['opponent'] : "BYE";
    }

    // Method to get all matchups
    public function getAllMatchups()
    {
        $sql = "SELECT * FROM matchups";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get the current week based on today's date
    public function getCurrentNFLWeek($today)
    {
        try {
            $query = "SELECT DISTINCT week, date FROM matchups ORDER BY date";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$rows) {
                error_log("No data returned from the matchups table.");
                return null;
            }

            foreach ($rows as $row) {
                if ($row['date'] >= $today) {
                    return (int)$row['week'];
                }
            }

            return (int)end($rows)['week'];
        } catch (PDOException $e) {
            error_log("Database error in getCurrentNFLWeek: " . $e->getMessage());
            return null;
        }
    }

    // Method to get the most recent team for a player in full name format
    public function getMostRecentTeam($playerName)
    {
        try {
            // Query to get the recent team name directly from player_stats
            $query = "
                SELECT recent_team 
                FROM player_stats 
                WHERE player_display_name = :player_name
                ORDER BY season ASC 
                LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);
            $stmt->execute();
            $teamName = $stmt->fetchColumn();

            // Fallback to team mapping if team name is missing
            // if (!$teamName && isset($this->teamMapping)) {
            //     return $this->teamMapping[$teamName] ?? null;
            // }

            return $this->teamMapping[$teamName];
        } catch (PDOException $e) {
            error_log("Database error in getMostRecentTeam for player '$playerName': " . $e->getMessage());
            return null;
        }
    }
    public function getQBStats($playerName, $opponent)
    {
        // Check if the player is a QB
        $query = "SELECT position FROM player_stats WHERE player_display_name = :player_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);
        $stmt->execute();
        $player = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ensure we have a valid player and check if they are a QB
        if ($player && $player['position'] === 'QB') {
            // Reverse the team mapping to get the opponent abbreviation
            $opponentAbbr = array_search($opponent, $this->teamMapping);

            // If no match is found for the team abbreviation, return null
            if (!$opponentAbbr) {
                return null;
            }

            // Fetch QB stats for the opponent team
            $query = "
                SELECT season, opponent_team, completions, attempts, passing_tds, fantasy_points
                FROM player_stats
                WHERE player_display_name = :player_name AND opponent_team = :opponent_team
                ORDER BY season DESC";
            $stmt1 = $this->db->prepare($query);
            $stmt1->bindParam(':player_name', $playerName, PDO::PARAM_STR);
            $stmt1->bindParam(':opponent_team', $opponentAbbr, PDO::PARAM_STR);
            $stmt1->execute();

            // Fetch all the stats and add them to the qbStats array
            $qbStats = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            return $qbStats; // Return the stats data as an associative array
        }

        return null; // Return null if the player is not a QB or does not exist
    }

    public function getRBStats($playerName, $opponent)
    {
        // Check if the player is an RB
        $query = "SELECT position FROM player_stats WHERE player_display_name = :player_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);
        $stmt->execute();
        $player = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ensure the player is valid and an RB
        if ($player && $player['position'] === 'RB') {
            // Reverse the team mapping to get the opponent abbreviation
            $opponentAbbr = array_search($opponent, $this->teamMapping);

            // If no match is found for the team abbreviation, return null
            if (!$opponentAbbr) {
                return null;
            }

            // Fetch RB stats for the opponent team
            $query = "
                SELECT season, opponent_team, rushing_yards, rushing_tds, receptions, receiving_yards, fantasy_points
                FROM player_stats
                WHERE player_display_name = :player_name AND opponent_team = :opponent_team
                ORDER BY season DESC";
            $stmt1 = $this->db->prepare($query);
            $stmt1->bindParam(':player_name', $playerName, PDO::PARAM_STR);
            $stmt1->bindParam(':opponent_team', $opponentAbbr, PDO::PARAM_STR);
            $stmt1->execute();

            // Fetch all the stats and add them to the rbStats array
            $rbStats = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            return $rbStats; // Return the stats data as an associative array
        }

        return null; // Return null if the player is not an RB or does not exist
    }

    public function getWRStats($playerName, $opponent)
    {
        // Check if the player is a WR
        $query = "SELECT position FROM player_stats WHERE player_display_name = :player_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);
        $stmt->execute();
        $player = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ensure the player is valid and a WR
        if ($player && $player['position'] === 'WR') {
            // Reverse the team mapping to get the opponent abbreviation
            $opponentAbbr = array_search($opponent, $this->teamMapping);

            // If no match is found for the team abbreviation, return null
            if (!$opponentAbbr) {
                return null;
            }

            // Fetch WR stats for the opponent team
            $query = "
                SELECT season, targets, opponent_team, receptions, receiving_yards, receiving_tds, fantasy_points
                FROM player_stats
                WHERE player_display_name = :player_name AND opponent_team = :opponent_team
                ORDER BY season DESC";
            $stmt1 = $this->db->prepare($query);
            $stmt1->bindParam(':player_name', $playerName, PDO::PARAM_STR);
            $stmt1->bindParam(':opponent_team', $opponentAbbr, PDO::PARAM_STR);
            $stmt1->execute();

            // Fetch all the stats and add them to the wrStats array
            $wrStats = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            return $wrStats; // Return the stats data as an associative array
        }

        return null; // Return null if the player is not a WR or does not exist
    }
    public function savePlayer($playerID, $playerName, $position, $team)
    {
        try {
            $query = "INSERT INTO saved_players (player_id, player_name, position, team)
                  VALUES (:player_id, :player_name, :position, :team)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':player_id', $playerID, PDO::PARAM_STR);
            $stmt->bindParam(':player_name', $playerName, PDO::PARAM_STR);
            $stmt->bindParam(':position', $position, PDO::PARAM_STR);
            $stmt->bindParam(':team', $team, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error saving player: " . $e->getMessage());
            return false;
        }
    }


    // Method to delete a player from the "Saved Players" list
    public function deletePlayer($playerId, $playerName)
    {
        try {
            //error_log("Deleting player with ID: " . $playerId, $playerName);
            // Ensure this query is correctly deleting only the specific player row
            $query = "DELETE FROM saved_players WHERE player_id = :player_id AND player_name = :name";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':player_id', $playerId, PDO::PARAM_STR);
            $stmt->bindParam(':name', $playerName, PDO::PARAM_STR);

            // Ensure this execute statement is returning true/false properly
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting player: " . $e->getMessage());
            return false;
        }
    }



    // Method to retrieve all saved players
    public function getSavedPlayers()
    {
        try {
            $query = "SELECT * FROM saved_players";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error retrieving saved players: " . $e->getMessage());
            return [];
        }
    }
}
