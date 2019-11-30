<?php

namespace app\models;

use app\models\Photos;
use app\database\DB;

/**
 * This is the model class for table "Article".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $cdate
 */
class Article extends DB
{

    const PHOTO_SIZE_15MB = 15000000;

    public $articleId;
    private $name,
            $type,
            $tmpName,
            $error,
            $size;

    public function saveArticle(int $userId): int
    {

        $articleId = DB::add("INSERT INTO `article` SET `author_id` = :author_id, `cdate` = :cdate", ['author_id' => $userId, 'cdate' => time()]);

        return $articleId;
    }

    public function saveUserPhotos(array $files, int $userId)
    {
        $inputPhotos = $files['upload'];

        $response = 'Фото сохранены успешно';
        foreach ($inputPhotos['name'] as $index => $value) {

            $this->name = $inputPhotos['name'][$index];
            $this->type = $inputPhotos['type'][$index];
            $this->tmpName = $inputPhotos['tmp_name'][$index];
            $this->size = $inputPhotos['size'][$index];
            $this->error = $inputPhotos['error'][$index];
            
            if (!$this->isPhotoNotLoaded()) { //проверки не работают
                return $this->isPhotoNotLoaded();
            }
            //TODO возвращается неверный articleId, почему то всегда возвращает 1
            $articleId = $this->saveArticle($userId);
            $this->uploadPhotoOnServer($articleId, $userId);
        }

        return $response;
    }

    protected function isPhotoNotLoaded()
    {
        $response = '';
        $photoNotLoaded = true;

        if ($this->size >= self::PHOTO_SIZE_15MB) {
            return $response = 'Превышен максимально допустимый размер фото 100 мб. Уменьшите размер фото, либо загрузите другое';
        } elseif ($this->error !== UPLOAD_ERR_OK) {
            return $response = $this->error;
        }

        return $photoNotLoaded;
    }

    protected function uploadPhotoOnServer(int $articleId, int $userId)
    {
        // Достаем формат изображения
        $imageFormat = explode('.', $this->name)[1];

        // Генерируем новое имя для изображения. Можно сохранить и со старым
        // но это не рекомендуется делать

        $path = PROJECT . '/files/images/' . ceil($articleId / 1000) . '/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $imageFullName = $path . $userId . '/' . $articleId . '.' . $imageFormat;

        // Сверяем доступные форматы изображений, если изображение соответствует,
        // копируем изображение в папку images

        if ($this->isAllowedPhotoType()) {
            move_uploaded_file($this->type, $imageFullName);
        }

        $photosModel = new Photos();
        $photosModel->savePhoto($articleId, $imageFullName);
    }

    public function isAllowedPhotoType()
    {
        return $this->type == 'image/jpeg' || $this->type == 'image/png' || $this->type == 'image/jpg' || $this->type == 'image/gif';
    }

}
