<?php

namespace app\controllers;

use app\core\Controller;

class PhotosController extends Controller
{
    public $userId;

    public function index()
    {
        $this->userId = filter_input(INPUT_COOKIE, 'userId');

        if (empty($_SESSION['userSession']) && !$this->userId) {
            $this->redirect('http://dummyadmin/index');
        }

        $user = $this->model('User');
        
        $currentUser = $user->getUser($this->userId);

        $this->view('photo', ['currentUser' => $currentUser]);
    }
    
    public function upload() :string
    {
        $files = $_FILES;
        
        $userId = filter_input(INPUT_COOKIE, 'userId');
        
        $response = [];
        $response['message'] = '';

        if (empty($files['upload'])) {
            $response['message'] = 'Нет фото для сохранения';
        } else {
            $article = $this->model('Article');
            $response['message'] = $article->saveUserPhotos($files, $userId);
        }
        
        return json_encode([$response]);
    }

}