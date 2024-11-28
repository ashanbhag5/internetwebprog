<?php
require_once 'Database.php';
require_once 'models/Player.php';

class PlayerController {
    private $playerModel;

    public function __construct($playerModel) {
        $this->playerModel = $playerModel;
    }

    public function getPlayerStats($playerName) {
        return $this->playerModel->getPlayerStats($playerName);
    }
}
?>
