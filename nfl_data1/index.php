<?php
require_once 'Database.php';
require_once 'models/Player.php';
require_once 'controllers/PlayerController.php';

// Establish database connection
$db = (new Database())->connect();
$playerModel = new Player($db);
$playerController = new PlayerController($playerModel);

// Initialize variable for stats
$playerStats = null;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerName = trim($_POST['player_name']);
    $playerStats = $playerController->getPlayerStats($playerName);
}

// Load the view
require_once 'views/player_view.php';
?>
