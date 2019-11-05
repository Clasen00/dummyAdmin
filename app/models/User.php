<?php

namespace app\models;

use app\database\DB;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $id_ancestor
 * @property string $id_region
 * @property integer $macroreg
 */
class User extends DB {

    public $title = 'User model';
    
    public $email;
    public $firstName;
    public $secondName;
    public $password;

    public function login(): string {
        return 'You have been successfully logged!';
    }

    public function getUser(int $userId): array {
        $user = DB::getRow("SELECT * FROM `user` WHERE `id` = :id", ['id' => 1]);

        return $user;
    }

    public function setUser(): int {
        $insertUserId = DB::add("INSERT INTO `user` SET `first-name` = ?, `second-name` = ?, `email` = ?, `password` = ?", ['first-name' => $this->firstName, 'second-name' => $this->secondName, 'email' => $this->email, 'password' => $this->password]);

        return $insertUserId;
    }

    public function validateUser(array $userData) {
        
        $validated = [];
        $validated['isValidated'] = true;
        
        if (!$userData['email']) {
            $validated['isValidated'] = false;
            $validated['message'] = "Введите пароль";
        }

        if (!$userData['first-name']) {
            $validated['isValidated'] = false;
            $validated['Введите имя'] = "Введите пароль";
        }

        if (!$userData['password']) {
            $validated['isValidated'] = false;
            $validated['message'] = "Пароль";
        }
        
        return $validated;
    }

}
