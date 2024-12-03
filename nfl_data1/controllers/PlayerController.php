<?php
require_once 'Database.php';
require_once 'models/PlayerModel.php';



// Create a database connection
$db = (new Database())->connect();
$playerModel = new PlayerModel($db);

class PlayerController
{
    public $db = (new Database())->connect();
    public $playerModel = new PlayerModel($db);




    public function getPlayerStats($playerName)
    {
        return $this->playerModel->getPlayerStats($playerName);
    }
    public function getPlayerNames($query)

    {
        header('Content-Type: application/json');
        return $this->playerModel->getPlayerNames($query);
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
}
