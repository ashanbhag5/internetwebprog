<?php
require_once 'Database.php';
require_once 'models/PlayerModel.php';



// Create a database connection
$db = (new Database())->connect();
$playerModel = new PlayerModel($db);

class PlayerController
{
    private $playerModel;




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
}
