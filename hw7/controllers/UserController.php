<?php
require_once 'models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Method to serve an HTML page
    public function getUserPage() {
        include 'views/userPage.html';
    }

    // Method to serve JSON data
    public function getJsonData() {
        header('Content-Type: application/json');
        $users = $this->userModel->getAllUsers();
        echo json_encode([
            'status' => 'success',
            'data' => $users
        ]);
    }
}