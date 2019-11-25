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
class User extends DB
{

    public $email;
    public $firstName;
    public $secondName;
    public $password;

    public function getUser(int $userId): array
    {
        $user = DB::getRow("SELECT * FROM `user` WHERE `id` = :id", ['id' => $userId]);

        return $user;
    }

    public function setUser(): int
    {

        $insertUserId = DB::add("INSERT INTO `user` SET `first_name` = :first_name, `second_name` = :second_name, `email` = :email, `password` = :password", ['first_name' => $this->firstName, 'second_name' => $this->secondName, 'email' => $this->email, 'password' => $this->password]);

        return $insertUserId;
    }

    public function validateUser(array $userData, bool $isReg = false): array
    {

        $validated = [];
        $validated['message'] = "Вы успешно зарегистрировались";
        $validated['isValidated'] = true;

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL) || !$userData['email']) {
            $validated['isValidated'] = false;
            $validated['message'] = "Введите корректную электронную почту";
            return $validated;
        } elseif ($isReg && !$userData['firstName']) {
            $validated['isValidated'] = false;
            $validated['message'] = "Введите имя";
            return $validated;
        } elseif (!$userData['password']) {
            $validated['isValidated'] = false;
            $validated['message'] = "Введите пароль";
            return $validated;
        }

        return $validated;
    }

    public function getRegisteredUser()
    {
        $user = DB::getRow("SELECT * FROM `user` WHERE `email` = :email AND `password` = :password", ['email' => $this->email, 'password' => $this->password]);

        return $user;
    }

    public function registrationUser(array $userFromData): int
    {
        $this->firstName = htmlentities($userFromData['firstName']);
        $this->secondName = htmlentities($userFromData['secondName']);
        $this->email = $userFromData['email'];
        $this->password = $userFromData['password'];

        $userId = $this->setUser();

        return $userId;
    }

}
