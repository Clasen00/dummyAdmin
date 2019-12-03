<?php

namespace app\models;

use app\database\DB;

/**
 * This is the model class for table "Photos".
 *
 * @property integer $user_id
 * @property string $path
 * @property string $filename
 */
class Photos extends DB {

    public function savePhoto(int $userId, string $path, string $filename): int {

        $photoId = DB::add("INSERT INTO `photos` SET `user_id` = :user_id, `path` = :path, `filename` = :filename", ['user_id' => $userId, 'path' => $path, 'filename' => $filename]);

        return $photoId;
    }
    
    public static function getUserPhoto(int $userId) {

        return DB::getAll("SELECT * FROM `photos` WHERE `user_id` = :user_id", ['user_id' => $userId]);

    }

}
