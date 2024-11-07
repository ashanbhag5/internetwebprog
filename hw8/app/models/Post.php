<?php

namespace app\models;

class Post {
    public function getAllPostsByTitle($params) {
        $allPosts = [
            [
                'id' => '1',
                'title' => 'Introduction to PHP',
                'content' => 'Test 1.'
            ],
            [
                'id' => '2',
                'title' => 'MVC Structure',
                'content' => 'Test 2.'
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
        //Placeholder
    }
}
