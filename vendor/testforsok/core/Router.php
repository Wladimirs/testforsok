<?php

namespace testforsok;

use RuntimeException;

class Router
{
    // Table of all routes
    protected static $routes = [];

    // Current route
    protected static $route = [];


    /**
     * Adding rules for the route table
     * @param $regexp
     * @param array $route
     */
    public static function add($regexp, $route = []): void
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * Test routes
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    /**
     * Test current route
     */
    public static function getRoute(): array
    {
        return self::$route;
    }


    /**
     * Accepts user-requested GET request
     * @param $url
     * @throws RuntimeException
     */
    public static function dispatch($url): void
    {
        $url = self::removeQueryString($url);

        if (self::matchRoute($url)) {
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';

            // Checking for the existence of the Controller class
            if (class_exists($controller)) {

                // Passing to the constructor of the controller (its object) all its parameters
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';

                // Method Existence Check
                if (method_exists($controllerObject, $action)) {

                    // Controller method call - $action()
                    $controllerObject->$action();

                    // Call from the base Controller object method getView()
                    //which receives data from base View
                    $controllerObject->getView();
                } else {
                    throw new \RuntimeException("$controller::$action method not found!", 404);
                }
            } else {
                throw new \RuntimeException("$controller controller not found!", 404);
            }
        } else {
            throw new \RuntimeException('Page not found!', 404);
        }
    }

    /**
     * Match search in the route table
     * @param $url
     * @return bool
     */
    public static function matchRoute($url): bool
    {
        foreach (self::$routes as $pattern => $route) {

            // Search for correspondence of this template with the address given in $url
            if (preg_match("#$pattern#i", $url, $matches)) {

                foreach ($matches as $key => $value) {

                    // Selection from an array of keys that have a string value
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }

                // If action is not specified in the url then we will assign index
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }

                // Check there is a prefix in the url of type public
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * The method will cast an uppercase lowercase letter in the name of the controller (controller)
     * in the url to a capital letter (CamelCase).
     * @param $name
     * @return mixed
     */
    protected static function upperCamelCase($name)
    {
        // str_replace - replaces a hyphen with a space
        // ucwords - makes every word with a capital letter
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * The method will cast the capital uppercase letter of the action name in the url
     * to a small letter (camelCase).
     * @param $name
     * @return string
     */
    protected static function lowerCamelCase($name): string
    {
        // lcfirst - make the first letter small
        return lcfirst(self::upperCamelCase($name));
    }

    /**
     * The method will strip the get parameters from the query string.
     * @param $url
     * @return string|null|false
     */
    protected static function removeQueryString($url): ?string
    {
        if (!empty($url)) {

            // Divide by ampersant (&) into two array values
            $params = explode('?', $url, 2);

            // Look in the first value of the array [0] the sign is (=)
            if (false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            }
            return '';
        }
        return false;
    }
}