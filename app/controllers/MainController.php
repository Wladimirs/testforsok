<?php

namespace app\controllers;

class MainController extends AppController
{
    /**
     * Passing parameters for the main page
     */
    public function indexAction(): void
    {
        $this->setMeta('Main Page', 'Main Page', 'Main,Page');
    }
}