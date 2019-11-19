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

    public function saveUserPhotos(array $files) {
        $photos = $files['uploads'];

        $response = 'Фото сохранены успешно';

        foreach ($photos as $index => $photo) {

            if ($this->validatePhoto($photo)) {
                return $this->validatePhoto($photo);
            }

            $this->uploadPhotoOnServer($photo);
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

    protected function uploadPhotoOnServer(array $photo) {
        // Достаем формат изображения
        $imageFormat = explode('.', $photo['name'])[1];

        // Генерируем новое имя для изображения. Можно сохранить и со старым
        // но это не рекомендуется делать
        $imageFullName = './images/' . hash('crc32', time()) . '.' . $imageFormat;

        // Сохраняем тип изображения в переменную
        $imageType = $photo['type'];

        // Сверяем доступные форматы изображений, если изображение соответствует,
        // копируем изображение в папку images
        if ($imageType == 'image/jpeg' || $imageType == 'image/png') {
            if (move_uploaded_file($photo['tmp_name'], $imageFullName)) {
                echo 'success';
            } else {
                echo 'error';
            }
            
            //придумать как отрпавлять ошибки, мб публичная переменная, заполнять имя изображения  
            //с помощью id статьи и id пользователя
        }
    }

}
