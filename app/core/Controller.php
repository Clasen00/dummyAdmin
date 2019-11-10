<?php

namespace app\core;

class Controller extends \app\core\Base
{

    /**
     * Return a new instance of a model or throw an exception.
     *
     * @param $model
     * @return mixed
     * @throws Exception
     */
    public function model($model)
    {
        $file = str_replace('\\', '/', APP . '/models/' . $model . '.php');
        
        if (is_readable($file)) {
            require_once $file;
            
            $model = 'app\\models\\' . $model;
            
            return new $model();
        }

        throw new Exception("The model $model does not exist or is not readable.");
    }

    /**
     * Return the master view with data containing the view
     * being requested as well as optional data.
     *
     * @param $view
     * @param array $data
     */
    public function view($view, $data = [])
    {
        $data['view'] = $view;

        extract($data);
        
        $file = str_replace('\\', '/', APP . '/views/pages/' . $view . '.php');

        if (is_readable($file)) {
            require_once $file;
        }
        else {
            $this->respondNotFound();
        }
    }
    
    /**
     * Redirecting to $url
     *
     * @param string $url
     */
    public static function redirect(string $url)
    {
        ob_start();
        header('Location: ' . $url);
        ob_end_flush();
        die();
    }
    
    /**
     * Setting user cookies for $userId and for time in $cookieExpiredTime
     *
     * @param int $userId
     * @param int $cookieExpiredTime
     */
    public static function setUserCookie(int $userId, int $cookieExpiredTime)
    {
        setcookie('userId', $userId, $cookieExpiredTime, '/');
    }
    
    /**
     * Setting user session settings for $userId
     *
     * @param int $userId
     * @param bool $isAuth
     */
    public static function setUserSession(int $userId, bool $isAuth)
    {
        if (empty($_SESSION['userSession']) || $_SESSION['userSession']['userId'] !== $userId) {
            $_SESSION['userSession']['userId'] = $userId;
            $_SESSION['userSession']['loggedin'] = $isAuth;
        }
    }
    
}