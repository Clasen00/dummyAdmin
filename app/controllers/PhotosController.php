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
    
    public function upload()
    {
        $files = $_FILES;
        
        $response = [];
        $response['message'] = "Фотографии загружены куда надо!";
//        $response['isValidated'] = false;
        
        if (empty($files['upload'])) {
            $response['message'] = "Нет фото для сохранения";
        }
        
        return json_encode([$response]);
    }

}