<?php

namespace testforsok\base;

use Exception;

class View
{
    // Array of the current route(controller, action, prefix)
    public $route;

    public $controller;
    public $model;
    public $view;
    public $layout;
    public $prefix;

    // Property for transferring page content from the controller to the view
    public $data = [];

    // Property to transfer meta data from the controller to the view
    public $meta = [];

    public function __construct($route, $layout = '', $view = '', $meta)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $view;
        $this->prefix = $route['prefix'];
        $this->meta = $meta;

        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
    }


    /**
     * Creating a page for the user
     * @param $data
     * @throws Exception
     */
    public function render($data): void
    {
        // Extracting data from an array and generating them
        if (is_array($data)) {
            // Extract data from data array into variables
            extract($data);
        }

        $this->prefix = str_replace("\\", "/", $this->prefix);
        $viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";

        if (is_file($viewFile)) {
            // Enabling buffering to use this view in the template
            ob_start();

            require_once $viewFile;

            // Buffering cleansing, with data entered into the variable $ content
            $content = ob_get_clean();
        } else {
            throw new \RuntimeException("Not found view - {$viewFile}", 500);
        }

        // Template Connection
        if (false !== $this->layout) {
            $layoutFile = APP . "/views/layouts/{$this->layout}.php";

            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \RuntimeException("Template not found - {$layoutFile}", 500);
            }
        }
    }

    /**
     * Meta data output
     * @return string
     */
    public function getMeta(): string
    {
        $output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL;
        $output .= '<meta name="description" content="' . $this->meta['desc'] . '">' . PHP_EOL;
        $output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
        return $output;
    }
}