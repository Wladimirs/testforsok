<?php

namespace testforsok\base;

use Exception;

abstract class Controller
{
    // Array of the current route(controller, action, prefix)
    public $route;

    public $controller;

    public $model;

    public $view;

    public $prefix;

    public $layout;

    // Property for transferring page content from the controller to the view
    public $data = [];

    // Property to transfer meta data from the controller to the view
    public $meta = ['title' => '', 'desc' => '', 'keywords' => ''];

    // csrf protection property
    protected $token;

    public function __construct($route)
    {
        $this->route = $route;

        $this->controller = $route['controller'];

        $this->model = $route['controller'];

        $this->view = $route['action'];

        $this->prefix = $route['prefix'];

        $this->token = !empty($_SESSION['token']) ? $_SESSION['token'] : $this->createToken();
    }

    /**
     * Method for retrieving data from a view
     * @throws Exception
     */
    public function getView(): void
    {
        // Creating a view object and transferring data to it
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);

        $viewObject->render($this->data);
    }

    /**
     * Method for transferring data from the controller to the view
     * @param $data
     */
    public function set($data): void
    {
        $this->data = $data;
    }

    /**
     * Method for transferring meta data from the controller to the view
     * @param string $title
     * @param string $desc
     * @param string $keywords
     */
    public function setMeta($title = '', $desc = '', $keywords = ''): void
    {
        $this->meta['title'] = h($title);

        $this->meta['desc'] = h($desc);

        $this->meta['keywords'] = h($keywords);
    }


    /**
     * Method for comparing the current token with the one recorded in the session
     * @param $token
     * @return bool
     */
    protected function tokenMatch($token): bool
    {
        return isset($_SESSION['token']) ? hash_equals($token, $_SESSION['token']) : false;
    }

    /**
     * Creating a token and passing its value to the session
     * @param int $length
     * @return string
     */
    protected function createToken($length = 32): string
    {
        // Symbols for generating a random string
        $ch = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';

        // Getting string length
        $max = strlen($ch) - 1;

        // Contains the resulting string
        $token = '';

        // Random number generation
        for ($i = 0; $i < $length; ++$i) {
            $token .= $ch[rand(0, $max)];
        }

        // Adding a session name to a token and hashing a string
        $token = md5($token . session_name());

        // Adding a ready token to the session
        $_SESSION['token'] = $token;

        return $token;
    }
}