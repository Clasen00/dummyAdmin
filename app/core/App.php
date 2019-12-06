<?php

namespace app\core;

class App extends \app\core\Base
{
    /**
     * This is the URL used to fetch the controller, method and params.
     *
     * @var
     */
    protected $url;
    /**
     * The default controller.
     *
     * @var string
     */
    protected $controller = 'IndexController';
    /**
     * The default method.
     *
     * @var string
     */
    protected $method = 'index';
    /**
     * Params from the URI; default empty array.
     *
     * @var array
     */
    protected $params = [];

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->url = $this->parseUrl();
    }

    /**
     * Run the app by calling the controller method and passing it
     * any given params.
     */
    public function dispatch()
    {
        $this->setController();

        $this->setMethod();

        $this->setParams();
        
        if (class_exists($this->controller)) {
            $controllerObject = new $this->controller();
            if (method_exists($controllerObject, $this->method)) {
                echo call_user_func_array([$controllerObject, $this->method], $this->params);
            } else {
                $this->respondNotFound();
            }
        } else {
            $this->respondNotFound();
        }
        
    }

    /**
     * Parse the url into an array so we can access the indexes as a
     * controller, method and optional params.
     *
     * @return array
     */
    private function parseUrl()
    {
        $requestUri = rtrim(filter_input_array(INPUT_SERVER)['REQUEST_URI']);
        
        if (isset($requestUri) && !empty($requestUri)) {
            return explode('/', str_replace('.php', '', $requestUri));
        }
    }

    /**
     * Set the controller using the first index of the url.
     */
    private function setController()
    {
        array_shift($this->url);
        
        if (empty($this->url[0])) {
            $this->url[0] = $this->method;
        }
        
        $this->url[0] = explode('?', $this->url[0])[0];
        $this->url[0] = ucfirst($this->url[0]);
        
        $path = str_replace('\\', '/', APP . '/controllers/' . $this->url[0] . 'Controller.php');
        
        if (file_exists($path)) {
            $this->controller = 'app\\controllers\\' . $this->url[0] . 'Controller';
            unset($this->url[0]);
        }
        else if (!file_exists($path) && !empty($this->url[0])) {
            $this->respondNotFound();
        }

        require_once $path;
    }

    /**
     * Set the method using the second index of the url.
     */
    private function setMethod()
    {
        if (isset($this->url[1]) && method_exists($this->controller, $this->url[1])) {
            $this->method = $this->url[1];
            unset($this->url[1]);
        }
    }

    /**
     * Set the params to pass to the controller method.
     *
     * Params equal the remaining values in the url array rebased.
     *
     * Additionally, we pass the $_POST super global for any optional
     * POST data
     */
    private function setParams()
    {
        $postRequest = filter_input_array(INPUT_POST);
        $getRequest = filter_input_array(INPUT_GET);
        
        $this->params = $this->url ? [array_values($this->url), $postRequest, $getRequest] : [$postRequest];
    }
}