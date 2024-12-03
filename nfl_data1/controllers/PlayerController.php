<?php
require_once 'Database.php';
require_once 'models/PlayerModel.php';



// Create a database connection
$db = (new Database())->connect();
$playerModel = new PlayerModel($db);

class PlayerController
{
    //public $db = (new Database())->connect();
    //public $playerModel = new PlayerModel($db);




    public function getPlayerStats($playerName)
    {
        //return $this->playerModel->getPlayerStats($playerName);
    }
    public function getPlayerNames($query)

    {
        header('Content-Type: application/json');
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        $data = $playerModel->getPlayerNames($query);
        echo json_encode($data);
        exit;
    }
    public function getPlayerMatchup($playerName)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        try {
            // Get the player's most recent team
            $team = $playerModel->getMostRecentTeam($playerName);

            // Get the current NFL week
            $week = $playerModel->getCurrentNFLWeek(date('Y-m-d'));

            // Fetch the matchup for the team and week
            $matchup = $playerModel->getMatchup($team, $week);

            // Return the player matchup information
            echo json_encode([
                'success' => true,
                'playerName' => $playerName,
                'team' => $team,
                'week' => $week,
                'matchup' => $matchup
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
    public function getAllMatchups()
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        $data = $playerModel->getAllMatchups();
        echo json_encode($data);
        exit;
    }
    public function getCurrentNFLWeek()
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        $today = date('Y-m-d');
        $currentWeek = $playerModel->getCurrentNFLWeek($today);
        echo json_encode(['currentWeek' => $currentWeek]);
        exit;
    }
    public function getMatchup($team, $week)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        $team = $_GET['team'];
        $week = $_GET['week'];
        $matchup = $playerModel->getMatchup($team, $week);
        echo json_encode($matchup);
        exit;
    }
    public function getMostRecentTeam($playerName)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        $recentTeam = $playerModel->getMostRecentTeam($playerName);
        echo json_encode(['recent_team' => $recentTeam]);
        exit;
    }
    public function getQBStats($playerName, $opponent)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);

        try {
            $qbStats = $playerModel->getQBStats($playerName, $opponent);
            if ($qbStats) {
                echo json_encode($qbStats);
            } else {
                echo json_encode([]);
            }
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching QB stats.']);
            exit;
        }
    }
    public function getRBStats($playerName, $opponent)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);

        try {
            $rbStats = $playerModel->getRBStats($playerName, $opponent);
            if ($rbStats) {
                echo json_encode($rbStats);
            } else {
                echo json_encode([]);
            }
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching RB stats.']);
            exit;
        }
    }
    public function getWRStats($playerName, $opponent)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        try {
            $wrStats = $playerModel->getWRStats($playerName, $opponent);
            if ($wrStats) {
                echo json_encode($wrStats);
            } else {
                echo json_encode([]);
            }
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while fetching WR stats.']);
            exit;
        }
    }
    public function getSavedPlayers()
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        $savedPlayers = $playerModel->getSavedPlayers();
        echo json_encode($savedPlayers);
        exit;
    }
}
