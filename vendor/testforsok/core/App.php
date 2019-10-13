<?php

namespace testforsok;

class App
{
    public static $app;

    public function __construct()
    {
        // Get query string
        $query = trim($_SERVER['REQUEST_URI'], '/');

        // Open session
        session_start();

        //$this->getParams();

        // Error output class
        new ErrorHandler();

        // Passing the query string to the router
        Router::dispatch($query);
    }
}