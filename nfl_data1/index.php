<?php
require_once 'Database.php';
require_once 'models/PlayerModel.php';
require_once "controllers/PlayerController.php";
require_once "controllers/PostController.php";



// Create a database connection
$db = (new Database())->connect();
$playerModel = new PlayerModel($db);

// Handle incoming GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check for 'action' in the URL
    if (isset($_GET['action'])) {
        header('Content-Type: application/json');

        // Autocomplete player names based on user query
        if ($_GET['action'] === 'getPlayerNames' && isset($_GET['query'])) {
            $playerController = new PlayerController();
            $query = $_GET['query'];
            $playerController->getPlayerNames($query);
            //Gets closest player names


        }

        // Get player statistics data from the db
        if ($_GET['action'] === 'getPlayerData' && isset($_GET['player_name'])) {
            $playerName = $_GET['player_name'];
            $data = $playerModel->getPlayerData($playerName);
            echo json_encode($data);
            exit;
        }


        // Get all matchups
        if ($_GET['action'] === 'getAllMatchups') {
            $playerController = new PlayerController();

            $playerController->getAllMatchups();
            // $data = $playerModel->getAllMatchups();
            // echo json_encode($data);
            // exit;
        }

        // Get the current NFL week
        if ($_GET['action'] === 'getCurrentNFLWeek') {
            $playerController = new PlayerController();

            $playerController->getCurrentNFLWeek();
        }

        // Get player matchup
        if ($_GET['action'] === 'getMatchup' && isset($_GET['team']) && isset($_GET['week'])) {
            $playerController = new PlayerController();
            $team = $_GET['team'];
            $week = $_GET['week'];
            $playerController->getMatchup($team, $week);
        }

        // Get player matchup (most recent team + current week matchup)
        if ($_GET['action'] === 'get_player_matchup' && isset($_GET['name'])) {

            $playerController = new PlayerController();
            $playerName = $_GET['name'];
            $playerController->getPlayerMatchup($playerName);
        }

        // Get the player's most recent team
        if ($_GET['action'] === 'getMostRecentTeam' && isset($_GET['player_name'])) {
            $playerController = new PlayerController();
            $playerName = $_GET['player_name'];
            $playerController->getMostRecentTeam($playerName);
        }

        // Get QB stats for a player and opponent
        if ($_GET['action'] === 'getQBStats' && isset($_GET['player_name']) && isset($_GET['opponent'])) {
            $playerController = new PlayerController();
            $playerName = $_GET['player_name'];
            $opponent = $_GET['opponent'];
            $playerController->getQBStats($playerName, $opponent);
        }

        // Get RB stats for a player and opponent
        if ($_GET['action'] === 'getRBStats' && isset($_GET['player_name']) && isset($_GET['opponent'])) {
            $playerController = new PlayerController();
            $playerName = $_GET['player_name'];
            $opponent = $_GET['opponent'];
            $playerController->getRBStats($playerName, $opponent);
        }
        // Get WR stats for a player and opponent
        if ($_GET['action'] === 'getWRStats' && isset($_GET['player_name']) && isset($_GET['opponent'])) {
            $playerController = new PlayerController();
            $playerName = $_GET['player_name'];
            $opponent = $_GET['opponent'];
            $playerController->getWRStats($playerName, $opponent);
        }


        // Get all saved players
        if ($_GET['action'] === 'getSavedPlayers') {
            $playerController = new PlayerController();

            $playerController->getSavedPlayers();
        }
    }




}
//Save a player
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'savePlayer') {
    header('Content-Type: application/json; charset=utf-8');

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['playerID'], $data['playerName'], $data['position'], $data['team'])) {
        //Gets these 4 pieces of data and sends it to the post controller
        $playerID = $data['playerID'];
        $playerName = $data['playerName'];
        $position = $data['position'];
        $team = $data['team'];
        $postController = new PostController();

        $postController->savePlayer($playerID, $playerName, $position, $team);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided']);
    }
}

//Delete player
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'deletePlayer') {
    header('Content-Type: application/json');

    // Get the data from the POST request
    $input = json_decode(file_get_contents('php://input'), true);
    $playerId = $input['player_id'];
    $playerName = $input['player_name'];
    $postController = new PostController();
    //Deletes player
    $postController->deletePlayer($playerId, $playerName);
    error_log("Received player_id for deletion: " . $playerId);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'getQBStats') {
    
    header('Content-Type: application/json');

    // Get QB name and opponent from the POST data
    //This is for the pie chart stats
    $postData = json_decode(file_get_contents('php://input'), true);
    $playerName = $postData['player_name'] ?? null;
    $opponent = $postData['opponent'] ?? null;
    $postController = new PostController();

    $postController->postQBStats($playerName, $opponent);
}


//Requires the player view
require_once 'views/player_view.php';
