<?php
require_once 'Database.php';  // Include database connection class
require_once 'models/PlayerModel.php';  // Include the PlayerModel class for database operations related to players

// Create a database connection
$db = (new Database())->connect();  // Establish a connection to the database
$playerModel = new PlayerModel($db);  // Instantiate the PlayerModel with the database connection

class PostController
{
    // The following properties are commented out but could be used to instantiate the database and player model
    //public $db = (new Database())->connect();
    //public $playerModel = new PlayerModel($db);

    // Method to retrieve player statistics (currently not implemented)
    public function getPlayerStats($playerName)
    {
        //return $this->playerModel->getPlayerStats($playerName);  // This would return player stats from the database
    }

    // Method to retrieve player names based on a search query
    public function getPlayerNames($query)
    {
        header('Content-Type: application/json');  // Set the content type to JSON for the response
        $db = (new Database())->connect();  // Establish a new database connection
        $playerModel = new PlayerModel($db);  // Instantiate the PlayerModel
        $data = $playerModel->getPlayerNames($query);  // Fetch player names from the database based on the query
        echo json_encode($data);  // Encode the data into JSON and send it as a response
        exit;  // End the script after sending the response
    }

    // Method to save a player's data to the database
    public function savePlayer($playerID, $playerName, $position, $team)
    {
        $db = (new Database())->connect();  // Create a new database connection
        $playerModel = new PlayerModel($db);  // Instantiate the PlayerModel with the database connection
        $success = $playerModel->savePlayer($playerID, $playerName, $position, $team);  // Save the player to the database

        if ($success) {
            echo json_encode(['success' => true, 'playerId' => 'Success']);  // Return a success message if player is saved
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save player in the database']);  // Return a failure message if saving fails
        }
        exit;  // End the script
    }

    // Method to delete a player from the database by player ID and name
    public function deletePlayer($playerId, $playerName)
    {
        $db = (new Database())->connect();  // Create a new database connection
        $playerModel = new PlayerModel($db);  // Instantiate the PlayerModel with the database connection
        if ($playerId) {  // Check if a player ID is provided
            $success = $playerModel->deletePlayer($playerId, $playerName);  // Delete the player from the database

            if ($success) {
                echo json_encode(['success' => true]);  // Return success message if player is deleted
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete player']);  // Return failure message if deletion fails
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid player ID']);  // Return error if player ID is invalid
        }

        exit;  // End the script
    }

    // Method to post QB (Quarterback) statistics based on player name and opponent
    public function postQBStats($playerName, $opponent)
    {
        $db = (new Database())->connect();  // Create a new database connection
        $playerModel = new PlayerModel($db);  // Instantiate the PlayerModel with the database connection
        if ($playerName && $opponent) {  // Ensure both player name and opponent are provided
            $qbStats = $playerModel->getQBStats($playerName, $opponent);  // Fetch QB stats for the given player and opponent
            if ($qbStats) {
                echo json_encode(['success' => true, 'data' => $qbStats]);  // Return success with QB stats if found
            } else {
                echo json_encode(['success' => false, 'message' => 'No stats found for the player.']);  // Return error if no stats are found
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);  // Return error if player name or opponent is missing
        }
        exit;
    }
}
