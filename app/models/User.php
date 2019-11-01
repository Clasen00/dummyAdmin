<?php

namespace app\models;

use app\database\DB;

class User extends DB {

    public $title = 'User model';

    public function login() {
        echo 'You have been successfully logged!';
    }
    
    public function getUser(int $userId): array
    {
        $user = DB::getRow("SELECT * FROM `category` WHERE `id` = :id", array('id' => $userId));
        
        return $user;
    }

}
