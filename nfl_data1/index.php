<?php
require_once 'Database.php';
require_once 'models/Player.php';
require_once 'controllers/PlayerController.php';


// Initialize database connection
$database = new Database();
$db = $database->connect();

// Initialize Player model
$playerModel = new Player($db);

// Handle AJAX GET requests
// Handle AJAX GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['player_name'])) {
    $playerName = trim($_GET['player_name']);
    $playerStats = $playerModel->getPlayerFantasyPoints($playerName);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($playerStats);
    exit;
}


// Load the view
require_once 'views/player_view.php';
