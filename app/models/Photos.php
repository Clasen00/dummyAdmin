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

    public function savePhoto(int $articleId, int $userId, string $filename): int {

        $photoId = DB::add("INSERT INTO `photos` SET `article_id` = :article_id, `user_id` = :user_id, `filename` = :filename", ['article_id' => $articleId, 'user_id' => $userId, 'filename' => $filename]);

        return $photoId;
    }
    
    public static function getUserPhoto(int $userId) {

        return DB::getAll("SELECT * FROM `photos` WHERE `user_id` = :user_id", ['user_id' => $userId]);

    }

}
