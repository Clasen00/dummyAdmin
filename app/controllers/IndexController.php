<?php

namespace app\controllers;

use app\core\Controller;

class IndexController extends Controller
{
    private $secondsInDay = 86400;
    private $secondsInWeek = 604800;
    private $isAuth;

    public function index()
    {
        session_start();
        $user = $this->model('User');
        
        $dontRegisterd = false;

        $userId = filter_input(INPUT_COOKIE, 'userId');
        
        if (!empty($userId)) {
            
            $currentUser = $user->getUser($userId);
            
            if (!empty($currentUser)) {
                ob_start();
                header('Location: http://dummyadmin/photos');
                ob_end_flush();
                die();
            }
            else {
                $dontRegisterd = true;
            }
        }
        else {
            $this->view('home', ['title' => $user->login(), 'dontRegisterd' => $dontRegisterd]);
        }
    }

    public function register()
    {
        $user = $this->model('User');
        
        $requestPost = filter_input_array(INPUT_POST);
        
        $validetedData = $user->validateUser($requestPost);
        
        if ($validetedData['isValidated'] !== true) {
            return json_encode([$validetedData]);
        }
        $userId = $user->registrationUser($requestPost);
        
        $this->setIsAuth(true);
        $this->setUserCookie($userId, $this->secondsInDay);
        $this->setUserSession($userId);
        
        return json_encode([$validetedData]);
    }

    public function setUserSession(int $userId)
    {//TODO многомерный массив
        if (!isset($_SESSION['userId'])) $_SESSION['userId'] = $userId;
        if (!isset($_SESSION['loggedin'])) $_SESSION['loggedin'] = $this->isAuth;
    }

    public function getIsAuth(): bool
    {
        return $this->isAuth;
    }

    public function setIsAuth(bool $isAuth)
    {
        $this->isAuth = $isAuth;
    }

    public function authUser()
    {
        $requestPost = filter_input_array(INPUT_POST);

        $user = $this->model('User');
        $user->email = $requestPost['email'];
        $user->password = $requestPost['password'];
        $rememberMeChecked = $requestPost['remember'];

        $authorizedUser = $user->getRegisteredUser();

        if (!empty($authorizedUser)) {
            $this->setIsAuth(true);
            $this->setUserSession($authorizedUser['id']);

            if (isset($rememberMeChecked)) {
                $this->setUserCookie($authorizedUser['id'], $this->secondsInWeek);
            }
            else {
                $this->setUserCookie($authorizedUser['id'], $this->secondsInDay);
            }
        }

        return json_encode([$authorizedUser]);
    }

    public function setUserCookie(int $userId, int $cookieExpiredTime)
    {
        setcookie('userId', $userId, time() + $cookieExpiredTime);
    }
}