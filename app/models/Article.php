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

    const PHOTO_SIZE_15MB = 15000000;

    public $articleId;

    public function saveArticle(int $userId): int {

        $insertArticleId = DB::add("INSERT INTO `article` SET `author_id` = :author_id, `cdate` = :cdate", ['author_id' => $userId, 'cdate' => time()]);

        $this->articleId = $insertArticleId;
    }

    public function saveUserPhotos(array $files, int $userId) {
        $photos = $files['upload'];

        $response = 'Фото сохранены успешно';

        foreach ($photos as $index => $photo) {

            if ($this->isPhotoLoaded($photo)) {
                return $this->isPhotoLoaded($photo);
            }

            $this->saveArticle($photo, $userId);
            $this->uploadPhotoOnServer($photo, $userId);
        }

        return $response;
    }

    protected function isPhotoLoaded(array $photo) {
        $response = '';
        $photoNotLoaded = false;

        if ($photo['size'] >= self::PHOTO_SIZE_15MB) {
            return $response = 'Превышен максимально допустимый размер фото 100 мб. Уменьшите размер фото, либо загрузите другое';
        } elseif ($photo['error'] !== UPLOAD_ERR_OK) {
            return $response = 'Возникла ошибка при загрузке фото';
        }

        return $photoNotLoaded;
    }

    protected function uploadPhotoOnServer(array $photo, int $userId) {
        // Достаем формат изображения
        $imageFormat = explode('.', $photo['name'])[1];

        // Генерируем новое имя для изображения. Можно сохранить и со старым
        // но это не рекомендуется делать

        $path = PROJECT . '/files/images/' . ceil($this->articleId / 1000) . '/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $imageFullName = $path . $userId . '/' . $this->articleId . '.' . $imageFormat;

        // Сохраняем тип изображения в переменную
        $photoType = $photo['type'];

        // Сверяем доступные форматы изображений, если изображение соответствует,
        // копируем изображение в папку images
        if ($this->isAllowedPhotoType($photoType)) {
            move_uploaded_file($photo['tmp_name'], $imageFullName);
        }
    }

    public function isAllowedPhotoType($photoType) {
        return $photoType == 'image/jpeg' || $photoType == 'image/png' || $photoType == 'image/jpg' || $photoType == 'image/gif';
    }

}
