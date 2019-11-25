<?php

namespace app\controllers;

use app\core\Controller;

class PhotosController extends Controller
{

    public function index()
    {
        $user = $this->model('User');
        
        if (!$this->userId) {
            $this->redirect('http://dummyadmin/index');
        }
        
        $currentUser = $user->getUser($this->userId);

        $this->view('photo', ['currentUser' => $currentUser]);
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