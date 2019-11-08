<?php

namespace app\controllers;

use app\core\Controller;

class PhotosController extends Controller
{
    public $userId;

    public function index()
    {
        $this->userId = filter_input(INPUT_COOKIE, 'userId');

        if (!$_SESSION['userSession']['loggedin'] && !$this->userId) {
            $this->redirect('http://dummyadmin/index');
        }

        $user = $this->model('User');
        $currentUser = $user->getUser($this->userId);

        $this->view('photo', ['currentUser' => $currentUser]);
    }

}