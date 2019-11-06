<?php

namespace app\models;

use app\database\DB;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $second_name
 * @property integer $email
 * @property integer $password
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
        $user = DB::getRow("SELECT * FROM `user` WHERE `id` = :id", ['id' => $userId]);

        return $user;
    }

    public function setUser(): int {
        
        $insertUserId = DB::add("INSERT INTO `user` SET `first_name` = :first_name, `second_name` = :second_name, `email` = :email, `password` = :password", ['first_name' => $this->firstName, 'second_name' => $this->secondName, 'email' => $this->email, 'password' => $this->password]);
        
        return $insertUserId;
    }

    public function validateUser(array $userData) {
        
        $validated = [];
        $validated['message'] = "Вы успешно зарегистрировались";
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
    
    public function getRegisteredUser(): array {
        $user = DB::getRow("SELECT * FROM `user` WHERE `email` = :email AND `password` = :password", ['email' => $this->email, 'password' => $this->password]);

        return $user;
    }
    
    public function registrationUser(array $userFromData):int
    {
        $user->firstName = $userFromData['first-name'];
        $user->secondName = $userFromData['second-name'];
        $user->email = $userFromData['email'];
        $user->password = $userFromData['password'];
        $userId = $this->setUser();
        
        return $userId;
    }

}
