<?php

class User {

    public function getAllUsers() {
        return [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@gmail.com'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@yahoo.com'
            ],
            [
                'id' => 3,
                'name' => 'Alice Johnson',
                'email' => 'alice@gmail.com'
            ]
        ];
    }
}
?>