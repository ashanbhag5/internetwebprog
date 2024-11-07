<?php

namespace app\models;

class Post {
    public function getAllPostsByTitle($params) {
        $allPosts = [
            [
                'id' => '1',
                'title' => 'Introduction to PHP',
                'content' => 'This post covers basics of PHP programming.'
            ],
            [
                'id' => '2',
                'title' => 'MVC Structure',
                'content' => 'Understanding MVC structure in web applications.'
            ],
        ];

        if (!empty($params['title'])) {
            return array_filter($allPosts, function ($post) use ($params) {
                return stripos($post['title'], $params['title']) !== false;
            });
        }

        return $allPosts;
    }

    public function savePost($data) {
        // Placeholder: in future, this would save a post to the database
    }
}
