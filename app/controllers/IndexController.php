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
        $user = $this->model('User');

        $userId = filter_input(INPUT_COOKIE, $userId);

        if (!empty($userId)) {
            
            $currentUser = $user->getUser($userId);

            if ($_SESSION[$currentUser['id']['loggedin'] === true]) {
                header('Location: /photos');
            }
            else {
                header('Location: /index?registred=false');
            }
        }
        else {
            $this->view('home', ['title' => $user->login()]);
        }
    }

    public function registerUser()
    {

        $user = $this->model('User');

        $requestPost = filter_input_array(INPUT_POST);
        $validetedData = $user->validateUser($requestPost);

        if ($validetedData['isValidated'] !== true) {
            return json_encode($validetedData);
        }
        
        $userId = $user->registrationUser($requestPost);
        
        $this->setIsAuth(true);
        $this->setUserCookie($userId, $this->secondsInDay);
        $this->setUserSession($userId);
        
        return json_encode($validetedData);
    }

    protected function setUserSession(int $userId)
    {
        if ($this->isAuth) {
            $_SESSION[$userId]['loggedin'] = $this->isAuth;
        }
    }

    protected function getIsAuth(): bool
    {
        return $this->isAuth;
    }

    protected function setIsAuth(bool $isAuth)
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

        $this->index();
    }

    protected function setUserCookie(int $userId, int $cookieExpiredTime)
    {
        setcookie('userId', $userId, time() + $cookieExpiredTime);
    }
}