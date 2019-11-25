<?php

namespace app\models;

use app\database\DB;
use app\models\Photos;

/**
 * This is the model class for table "Article".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $cdate
 */
class Article extends DB {

    const PHOTO_SIZE_15MB = 15000000;

    public $articleId;

    public function saveArticle(int $userId): int {

        $articleId = DB::add("INSERT INTO `article` SET `author_id` = :author_id, `cdate` = :cdate", ['author_id' => $userId, 'cdate' => time()]);

        return $articleId;
    }

    public function saveUserPhotos(array $files, int $userId) {
        $inputPhotos = $files['upload'];

        $response = 'Фото сохранены успешно';

        foreach ($inputPhotos as $photo) {

            if ($this->isPhotoLoaded($photo)) {
                return $this->isPhotoLoaded($photo);
            }
        var_dump($inputPhotos); exit;

            $articleId = $this->saveArticle($userId);
            $this->uploadPhotoOnServer($photo, $articleId, $userId);
        }

        return $response;
    }

    protected function isPhotoLoaded(array $photo) {
        $response = '';
        $photoNotLoaded = false;

        if ($photo['size'] >= self::PHOTO_SIZE_15MB) {
            return $response = 'Превышен максимально допустимый размер фото 100 мб. Уменьшите размер фото, либо загрузите другое';
        } elseif ($photo['error'] !== UPLOAD_ERR_OK) {
            return $response = $photo['error'];
        }

        return $photoNotLoaded;
    }

    protected function uploadPhotoOnServer(array $photo, int $articleId, int $userId) {
        // Достаем формат изображения
        $imageFormat = explode('.', $photo['name'])[1];

        // Генерируем новое имя для изображения. Можно сохранить и со старым
        // но это не рекомендуется делать

        $path = PROJECT . '/files/images/' . ceil($articleId / 1000) . '/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $imageFullName = $path . $userId . '/' . $articleId . '.' . $imageFormat;

        // Сохраняем тип изображения в переменную
        $photoType = $photo['type'];

        // Сверяем доступные форматы изображений, если изображение соответствует,
        // копируем изображение в папку images
        
        if ($this->isAllowedPhotoType($photoType)) {
            move_uploaded_file($photo['tmp_name'], $imageFullName);
        }
        
        $photosModel = $this->model('Photos');
        $photosModel->savePhoto($articleId, $imageFullName);

    }

    public function isAllowedPhotoType($photoType) {
        return $photoType == 'image/jpeg' || $photoType == 'image/png' || $photoType == 'image/jpg' || $photoType == 'image/gif';
    }

}
