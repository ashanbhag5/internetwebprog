<?php

namespace app\controllers;
use app\models\Post;

class PostController {
    public function getPosts() {
        $params = [
            'title' => $_GET['title'] ?? null,
        ];
        $postModel = new Post();
        $posts = $postModel->getAllPostsByTitle($params);
        header("Content-Type: application/json");
        echo json_encode($posts);
        exit();
    }

    public function savePost() {
        // Retrieve post data from form submission
        $title = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;
        $errors = [];

        // Validate title
        if ($title) {
            $title = htmlspecialchars($title);
            if (strlen($title) < 5) {
                $errors['title'] = 'Title must be at least 5 characters long.';
            }
        } else {
            $errors['title'] = 'Title is required.';
        }

        // Validate content
        if ($content) {
            $content = htmlspecialchars($content);
            if (strlen($content) < 20) {
                $errors['content'] = 'Content must be at least 20 characters long.';
            }
        } else {
            $errors['content'] = 'Content is required.';
        }

        // Return errors if any validation failed
        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }

        
        $postModel = new Post();
        $postModel->savePost(['title' => $title, 'content' => $content]);

        // Return the validated data
        $returnData = [
            'title' => $title,
            'content' => $content,
        ];
        echo json_encode($returnData);
        exit();
    }
}
