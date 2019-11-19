<?php

namespace app\controllers;

use app\core\Controller;

class IndexController extends Controller {

    private $secondsInDay = 86400;
    private $secondsInWeek = 604800;
    private $isAuth;

    public function index() {
        $user = $this->model('User');
        $needLogOut = filter_input(INPUT_GET, 'needlogout');
        $dontRegisterd = false;

        if ($needLogOut) {
            $this->logout();
        }

        if (!empty($_SESSION['userSession'])) {
            Controller::setUserCookie($_SESSION['userSession']['userId'], time() + $this->secondsInDay);
        }

        $userId = filter_input(INPUT_COOKIE, 'userId');

        if (!empty($userId)) {

            $currentUser = $user->getUser($userId);

            if (!empty($currentUser)) {
                Controller::redirect('http://dummyadmin/photos');
            } else {
                $dontRegisterd = true;
            }
        } else {
            $this->view('home', ['dontRegisterd' => $dontRegisterd]);
        }
    }

    public function register(): string {
        $user = $this->model('User');

        $requestPost = filter_input_array(INPUT_POST);

        $validetedData = $user->validateUser($requestPost, true);

        if ($validetedData['isValidated'] !== true) {
            return json_encode([$validetedData]);
        }
        $userId = $user->registrationUser($requestPost);

        $this->setIsAuth(true);
        Controller::setUserCookie($userId, time() + $this->secondsInDay);
        Controller::setUserSession($userId, $this->isAuth);

        return json_encode([$validetedData]);
    }

    public function auth(): string {
        $requestPost = filter_input_array(INPUT_POST);

        $user = $this->model('User');
        $user->email = $requestPost['email'];
        $user->password = $requestPost['password'];
        $rememberMe = $requestPost['remember'];
        $notAuth = [];
        $notAuth['message'] = "Неправильный логин или пароль";
        $notAuth['isValidated'] = false;

        $validetedData = $user->validateUser($requestPost);

        if ($validetedData['isValidated'] !== true) {
            return json_encode([$validetedData]);
        }

        $authorizedUser = $user->getRegisteredUser();

        if ($authorizedUser) {
            $this->setUserAuthParam($authorizedUser, $rememberMe);
        } else {
            return json_encode([$notAuth]);
        }

        return json_encode([$validetedData]);
    }

    public function logout() {
        unset($_SESSION['userSession']);
        setcookie("userId", "", time() - 23489321, "/");
    }

    public function setUserAuthParam(array $user, $rememberMe) {
        $this->setIsAuth(true);
        Controller::setUserSession($user['id'], $this->isAuth);

        if (!empty($rememberMe)) {
            Controller::setUserCookie($user['id'], time() + $this->secondsInWeek);
        } else {
            Controller::setUserCookie($user['id'], time() + $this->secondsInDay);
        }
    }

    public function getIsAuth(): bool {
        return $this->isAuth;
    }

    public function setIsAuth(bool $isAuth) {
        $this->isAuth = $isAuth;
    }

}
