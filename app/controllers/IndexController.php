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
        
        $this->setUserCookie($_SESSION['userSession']['userId'], $this->secondsInDay);
        
        $userId = filter_input(INPUT_COOKIE, 'userId');
        
        if (!empty($userId)) {
            
            $currentUser = $user->getUser($userId);
            
            if (!empty($currentUser)) {
                Controller::redirect('http://dummyadmin/photos');
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
        
        $validetedData = $user->validateUser($requestPost, true);
        
        if ($validetedData['isValidated'] !== true) {
            return json_encode([$validetedData]);
        }
        $userId = $user->registrationUser($requestPost);
        
        $this->setIsAuth(true);
        $this->setUserCookie($userId, $this->secondsInDay);
        $this->setUserSession($userId);
        
        return json_encode([$validetedData]);
    }

    public function auth()
    {
        $requestPost = filter_input_array(INPUT_POST);
        
        $user = $this->model('User');
        $user->email = $requestPost['email'];
        $user->password = $requestPost['password'];
        $rememberMe = $requestPost['remember'];

        $validetedData = $user->validateUser($requestPost);
        
        if ($validetedData['isValidated'] !== true) {
            return json_encode([$validetedData]);
        }
        
        $authorizedUser = $user->getRegisteredUser();

        if (!empty($authorizedUser)) {
            $this->setUserAuthParam($authorizedUser, $rememberMe);
        }

        return json_encode([$validetedData]);
    }
    
    public function setUserAuthParam(array $user, $rememberMe)
    {
        $this->setIsAuth(true);
        $this->setUserSession($user['id']);

        if (!empty($rememberMe)) {
            $this->setUserCookie($user['id'], $this->secondsInWeek);
        }
        else {
            $this->setUserCookie($user['id'], $this->secondsInDay);
        }
    }

    public function setUserCookie(int $userId, int $cookieExpiredTime)
    {
        setcookie('userId', $userId, time() + $cookieExpiredTime);
    }
    
    public function getIsAuth(): bool
    {
        return $this->isAuth;
    }

    public function setIsAuth(bool $isAuth)
    {
        $this->isAuth = $isAuth;
    }
    
    public function setUserSession(int $userId)
    {
        if ($_SESSION['userSession']['userId'] !== $userId || !isset($_SESSION['userSession']['userId'])) {
            $_SESSION['userSession']['userId'] = $userId;
            $_SESSION['userSession']['loggedin'] = $this->isAuth;
        }
    }
}