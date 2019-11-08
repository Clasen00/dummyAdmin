<?php

namespace app\controllers;

use app\core\Controller;

class PhotosController extends Controller
{
    public function index()
    {
        if (!$_SESSION['userSession']['loggedin']) {
            Controller::redirect('http://dummyadmin/index');
        }
        
        $user = $this->model('User');
        $userId = $_SESSION['userSession']['userId'];
        $currentUser = $user->getUser($userId);
        
        $this->view('photo', ['currentUser' => $currentUser]);
    }
}