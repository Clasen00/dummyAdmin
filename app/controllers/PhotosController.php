<?php

namespace app\controllers;

use app\core\Controller;

class PhotosController extends Controller
{
    public function index()
    {
        $user = $this->model('User');
        
        var_dump($_SESSION); exit;
        
        $this->view('photo', ['title' => $user->login()]);
    }
}