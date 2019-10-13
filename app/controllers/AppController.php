<?php

namespace app\controllers;

use app\models\AppModel;
use testforsok\base\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);

        new AppModel();
    }

    /**
     * Getting id from GET or POST requests
     * @param bool $get
     * @param string $id
     * @return int|string|null
     */
    public function getRequestID($get = true, $id = 'id')
    {
        $get ? $data = $_GET : $data = $_POST;

        $id = !empty($data[$id]) ? (int)$data[$id] : null;

        if (!$id) {
            throw new \RuntimeException('Page not found', 404);
        }

        return $id;
    }
}