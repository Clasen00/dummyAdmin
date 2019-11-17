<?php

namespace app\models;

use app\database\DB;

/**
 * This is the model class for table "Article".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $cdate
 */
class Article extends DB {
    
    const MAX_PHOTO_SIZE = 15000000;

    public function saveUserPhotos($files) {
        $photos = $files['uploads'];
        
        $response = 'Фото сохранены успешно';

        foreach ($photos as $index => $photo) {
            if ($photo['size'] >= self::MAX_PHOTO_SIZE) {
                return $response = 'Превышен максимально допустимый размер фото 100 мб. Уменьшите размер фото, либо загрузите другое';
            } elseif ($photo['error'] !== UPLOAD_ERR_OK) {
                return $response = 'Возникла ошибка при загрузке фото';
            }
            
            //сохранить фото
        }
        
    return $response;
    }

}
