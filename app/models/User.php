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

    public function login(): string {
        return 'You have been successfully logged!';
    }

    public function getUser(int $userId): array {
        $user = DB::getRow("SELECT * FROM `user` WHERE `id` = :id", ['id' => 1]);

        return $user;
    }

    public function setUser(array $userData): int {
        $insert_id = DB::add("INSERT INTO `user` SET `name` = ?", ['name' => 'Eugene']); //подставить значения из post

        return $insert_id;
    }

}
