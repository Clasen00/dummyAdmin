<?php

namespace app\controllers;

use app\core\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $user = $this->model('User');

        $this->view('home', ['title' => $user->title]);
    }
}