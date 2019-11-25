<?php

namespace app\models;

use app\database\DB;

/**
 * This is the model class for table "Photos".
 *
 * @property integer $article_id
 * @property integer $path
 */
class Photos extends DB {

    public function savePhoto(int $articleId, string $path): int {

        $photoId = DB::add("INSERT INTO `photos` SET `article_id` = :article_id, `path` = :path", ['article_id' => $articleId, 'path' => $path]);

        return $photoId;
    }

}
