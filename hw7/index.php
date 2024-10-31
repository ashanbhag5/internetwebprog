<?php
require_once 'controllers/UserController.php';

$controller = new UserController();

// Check the request URI and method
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/users') {
    $controller->getJsonData();
} else {
    $controller->getUserPage();
}
?>