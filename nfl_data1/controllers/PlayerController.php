<?php
// Including the necessary files for database and player models
require_once 'Database.php';
require_once 'models/PlayerModel.php';

// Create a new database connection
$db = (new Database())->connect();
// Instantiate the PlayerModel class with the database connection
$playerModel = new PlayerModel($db);

// Define the PlayerController class for handling various player-related actions
class PlayerController
{
    // Function to get player stats (currently not implemented)
    public function getPlayerStats($playerName)
    {

        // This function is meant to return the stats of a player based on the player name.
        // It will call the getPlayerStats method of the PlayerModel class.
        //return $this->playerModel->getPlayerStats($playerName);
    }

    // Function to get player names based on a search query
    public function getPlayerNames($query)
    {
        //Data validation
        if (empty($query) || !is_string($query)) {
            echo json_encode(['success' => false, 'message' => 'Invalid query.']);
            exit;
        }

        // Set the header for JSON response
        header('Content-Type: application/json');

        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        // Get the player names matching the query from the PlayerModel
        $data = $playerModel->getPlayerNames($query);

        // Return the data as a JSON response
        echo json_encode($data);
        exit;
    }

    // Function to get the matchup for a specific player
    public function getPlayerMatchup($playerName)
    {
        // Validates the player name
        if (empty($playerName) || !is_string($playerName)) {
            echo json_encode(['success' => false, 'message' => 'Invalid player name.']);
            exit;
        }

        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        try {
            // Get the player's most recent team
            $team = $playerModel->getMostRecentTeam($playerName);

            // Get the current NFL week using the current date
            $week = $playerModel->getCurrentNFLWeek(date('Y-m-d'));

            // Fetch the matchup for the team and week from the PlayerModel
            $matchup = $playerModel->getMatchup($team, $week);

            // Return the matchup information as a JSON response
            echo json_encode([
                'success' => true,
                'playerName' => $playerName,
                'team' => $team,
                'week' => $week,
                'matchup' => $matchup
            ]);
            exit;
        } catch (Exception $e) {
            // If an error occurs, return an error message in the JSON response
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }

    // Function to get all player matchups
    public function getAllMatchups()
    {
        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        // Get all matchups from the PlayerModel
        $data = $playerModel->getAllMatchups();

        // Return the data as a JSON response
        echo json_encode($data);
        exit;
    }

    // Function to get the current NFL week
    public function getCurrentNFLWeek()
    {
        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        // Get the current date and pass it to the PlayerModel to get the current NFL week
        $today = date('Y-m-d');
        $currentWeek = $playerModel->getCurrentNFLWeek($today);

        // Return the current NFL week as a JSON response
        echo json_encode(['currentWeek' => $currentWeek]);
        exit;
    }

    // Function to get a specific matchup based on the team and week
    public function getMatchup($team, $week)
    {
        if (empty($team) || !is_string($team)) {
            echo json_encode(['success' => false, 'message' => 'Invalid team name.']);
            exit;
        }
        if (empty($week) || !is_string($week)) {
            echo json_encode(['success' => false, 'message' => 'Invalid week name.']);
            exit;
        }
        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        // Fetch the matchup for the provided team and week
        $matchup = $playerModel->getMatchup($team, $week);

        // Return the matchup data as a JSON response
        echo json_encode($matchup);
        exit;
    }

    // Function to get the most recent team of a player
    public function getMostRecentTeam($playerName)
    {
        // Validates the player name
        if (empty($playerName) || !is_string($playerName)) {
            echo json_encode(['success' => false, 'message' => 'Invalid player name.']);
            exit;
        }
        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        // Get the most recent team for the player from the PlayerModel
        $recentTeam = $playerModel->getMostRecentTeam($playerName);

        // Return the recent team as a JSON response
        echo json_encode(['recent_team' => $recentTeam]);
        exit;
    }

    // Function to get quarterback stats for a player against an opponent
    public function getQBStats($playerName, $opponent)
    {
        // Validates the player name
        if (empty($playerName) || !is_string($playerName)) {
            echo json_encode(['success' => false, 'message' => 'Invalid player name.']);
            exit;
        }
        // Validates the opponent name
        if (empty($opponent) || !is_string($opponent)) {
            echo json_encode(['success' => false, 'message' => 'Invalid opponent name.']);
            exit;
        }

        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        try {
            // Get QB stats for the player against the opponent
            $qbStats = $playerModel->getQBStats($playerName, $opponent);

            // Return the QB stats if available, otherwise return an empty array
            if ($qbStats) {
                echo json_encode($qbStats);
            } else {
                echo json_encode([]);
            }
            exit;
        } catch (Exception $e) {
            // If an error occurs, return an error message
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching QB stats.']);
            exit;
        }
    }

    // Function to get running back stats for a player against an opponent
    public function getRBStats($playerName, $opponent)
    {
        // Validates the player name
        if (empty($playerName) || !is_string($playerName)) {
            echo json_encode(['success' => false, 'message' => 'Invalid player name.']);
            exit;
        }
        // Validates the opponent name
        if (empty($opponent) || !is_string($opponent)) {
            echo json_encode(['success' => false, 'message' => 'Invalid opponent name.']);
            exit;
        }

        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        try {
            // Get RB stats for the player against the opponent
            $rbStats = $playerModel->getRBStats($playerName, $opponent);

            // Return the RB stats if available, otherwise return an empty array
            if ($rbStats) {
                echo json_encode($rbStats);
            } else {
                echo json_encode([]);
            }
            exit;
        } catch (Exception $e) {
            // If an error occurs, return an error message
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching RB stats.']);
            exit;
        }
    }

    // Function to get wide receiver stats for a player against an opponent
    public function getWRStats($playerName, $opponent)
    {
        // Validates the player name
        if (empty($playerName) || !is_string($playerName)) {
            echo json_encode(['success' => false, 'message' => 'Invalid player name.']);
            exit;
        }
        // Validates the opponent name
        if (empty($opponent) || !is_string($opponent)) {
            echo json_encode(['success' => false, 'message' => 'Invalid opponent name.']);
            exit;
        }

        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        try {
            // Get WR stats for the player against the opponent
            $wrStats = $playerModel->getWRStats($playerName, $opponent);

            // Return the WR stats if available, otherwise return an empty array
            if ($wrStats) {
                echo json_encode($wrStats);
            } else {
                echo json_encode([]);
            }
            exit;
        } catch (Exception $e) {
            // If an error occurs, return an error message
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching WR stats.']);
            exit;
        }
    }

    // Function to get saved players from the database
    public function getSavedPlayers()
    {
        // Create a new database connection
        $db = (new Database())->connect();

        // Instantiate the PlayerModel class
        $playerModel = new PlayerModel($db);

        // Get the saved players from the PlayerModel
        $savedPlayers = $playerModel->getSavedPlayers();

        // Return the saved players as a JSON response
        echo json_encode($savedPlayers);
        exit;
    }
}
