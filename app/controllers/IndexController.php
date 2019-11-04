<?php

namespace app\controllers;

use app\core\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $user = $this->model('User');
        
        $postRequest = filter_input_array(INPUT_POST);
        
        if ($postRequest) {
            $user->setUser($postRequest);
        }

        $this->view('home', ['title' => $user->login()]);
    }
}