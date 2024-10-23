<?php
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/models/User.php';
use controllers\UserController;
$userController = new UserController();

$userController ->index();


?>