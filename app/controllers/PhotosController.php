<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Photos;

class PhotosController extends Controller
{

    public function index()
    {
        $user = $this->model('User');
        
        $currentUser = $user->getUser($this->userId);
        
        if (empty($currentUser)) {
            $this->redirect('http://dummyadmin/index');
        }
        
        $userPhotos = Photos::getUserPhoto($this->userId);
//TODO решить проблему отдачи файлов
        $this->view('photo', ['currentUser' => $currentUser, 'userPhotos' => $userPhotos]);
    }
    
    public function upload() :string
    {
        $files = $_FILES;
        
        $response = [];
        $response['message'] = '';

        if (empty($files['upload'])) {
            $response['message'] = 'Нет фото для сохранения';
        } else {
            $article = $this->model('Article');
            $response['message'] = $article->saveUserPhotos($files, $this->userId);
        }
        
        return json_encode([$response]);
    }

}