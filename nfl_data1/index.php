<?php
require_once 'Database.php';
require_once 'models/PlayerModel.php';
require_once "controllers/PlayerController.php";


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
            $data = $playerModel->getPlayerNames($query);
            echo json_encode($data);
            exit;
        }

        // Get player statistics data
        if ($_GET['action'] === 'getPlayerData' && isset($_GET['player_name'])) {
            $playerName = $_GET['player_name'];
            $data = $playerModel->getPlayerData($playerName);
            echo json_encode($data);
            exit;
        }


        // Get all matchups
        if ($_GET['action'] === 'getAllMatchups') {
            $data = $playerModel->getAllMatchups();
            echo json_encode($data);
            exit;
        }

        // Get the current NFL week
        if ($_GET['action'] === 'getCurrentNFLWeek') {
            $today = date('Y-m-d');
            $currentWeek = $playerModel->getCurrentNFLWeek($today);
            echo json_encode(['currentWeek' => $currentWeek]);
            exit;
        }

        // Get player matchup
        if ($_GET['action'] === 'getMatchup' && isset($_GET['team']) && isset($_GET['week'])) {

            $team = $_GET['team'];
            $week = $_GET['week'];
            $matchup = $playerModel->getMatchup($team, $week);
            echo json_encode($matchup);
            exit;
        }

        // Get player matchup (most recent team + current week matchup)
        if ($_GET['action'] === 'get_player_matchup' && isset($_GET['name'])) {
            $playerName = $_GET['name'];

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

        // Get the player's most recent team
        if ($_GET['action'] === 'getMostRecentTeam' && isset($_GET['player_name'])) {
            $playerName = $_GET['player_name'];
            $recentTeam = $playerModel->getMostRecentTeam($playerName);
            echo json_encode(['recent_team' => $recentTeam]);
            exit;
        }

        // Get QB stats for a player and opponent
        if ($_GET['action'] === 'getQBStats' && isset($_GET['player_name']) && isset($_GET['opponent'])) {
            $playerName = $_GET['player_name'];
            $opponent = $_GET['opponent'];

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


        if ($_GET['action'] === 'getRBStats' && isset($_GET['player_name']) && isset($_GET['opponent'])) {
            $playerName = $_GET['player_name'];
            $opponent = $_GET['opponent'];

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

        if ($_GET['action'] === 'getWRStats' && isset($_GET['player_name']) && isset($_GET['opponent'])) {
            $playerName = $_GET['player_name'];
            $opponent = $_GET['opponent'];

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


        // Delete a player from saved players


        // Get all saved players
        if ($_GET['action'] === 'getSavedPlayers') {
            $savedPlayers = $playerModel->getSavedPlayers();
            echo json_encode($savedPlayers);
            exit;
        }
    }



    // Default to loading the player view

}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'savePlayer') {
    header('Content-Type: application/json; charset=utf-8');
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['playerID'], $data['playerName'], $data['position'], $data['team'])) {
        $playerID = $data['playerID'];
        $playerName = $data['playerName'];
        $position = $data['position'];
        $team = $data['team'];

        $success = $playerModel->savePlayer($playerID, $playerName, $position, $team);

        if ($success) {
            echo json_encode(['success' => true, 'playerId' => 'Success']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save player in the database']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided']);
    }
    // Terminate script to prevent additional output
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'deletePlayer') {
    header('Content-Type: application/json');

    // Get the data from the POST request
    $input = json_decode(file_get_contents('php://input'), true);
    $playerId = $input['player_id'];
    $playerName = $input['player_name'];
    error_log("Received player_id for deletion: " . $playerId);

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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'getQBStats') {
    // Include PlayerModel if not already included
    header('Content-Type: application/json');

    // Get QB name and opponent from the POST data
    $postData = json_decode(file_get_contents('php://input'), true);
    $playerName = $postData['player_name'] ?? null;
    $opponent = $postData['opponent'] ?? null;

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



require_once 'views/player_view.php';
