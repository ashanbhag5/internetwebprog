<?php
require_once 'Database.php';
require_once 'models/PlayerModel.php';



// Create a database connection
$db = (new Database())->connect();
$playerModel = new PlayerModel($db);

class PostController
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
    public function savePlayer($playerID, $playerName, $position, $team)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        $success = $playerModel->savePlayer($playerID, $playerName, $position, $team);

        if ($success) {
            echo json_encode(['success' => true, 'playerId' => 'Success']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save player in the database']);
        }
        exit;
    }
    public function deletePlayer($playerId, $playerName)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        if ($playerId) {
            $success = $playerModel->deletePlayer($playerId, $playerName);

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete player']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid player ID']);
        }

        exit;
    }
    public function postQBStats($playerName, $opponent)
    {
        $db = (new Database())->connect();
        $playerModel = new PlayerModel($db);
        if ($playerName && $opponent) {
            $qbStats = $playerModel->getQBStats($playerName, $opponent);
            if ($qbStats) {
                echo json_encode(['success' => true, 'data' => $qbStats]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No stats found for the player.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        }
        exit;
    }
}
