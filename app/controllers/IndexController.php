<?php

namespace app\controllers;

use app\core\Controller;

class IndexController extends Controller {

    private $hoursInDay = 86400;

    public function index() {//TODO после успешного логина перекидывать на photos
        $user = $this->model('User');

        $this->view('home', ['title' => $user->login()]);
    }

    public function getUserInfo() {
        $user = $this->model('User');

        $requestPost = filter_input_array(INPUT_POST);

        if ($user->validateUser($requestPost)) {
            $user->firstName = $requestPost['first-name'];
            $user->secondName = $requestPost['second-name'];
            $user->email = $requestPost['email'];
            $user->password = $requestPost['password'];

            $userId = $user->setUser();
        }

        setcookie("userId", $userId, time() + $this->hoursInDay);

        return $userId;
    }

}
