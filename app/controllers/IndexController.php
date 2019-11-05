<?php

namespace app\controllers;

use app\core\Controller;

class IndexController extends Controller
{

    public function index()
    {//TODO после успешного логина перекидывать на photos
        $user = $this->model('User');

        $this->view('home', ['title' => $user->login()]);
    }

    public function getUserInfo() 
    {
        var_dump($_POST); exit;
    }
}