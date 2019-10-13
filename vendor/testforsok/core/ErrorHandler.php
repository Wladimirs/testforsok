<?php

namespace testforsok;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }

        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * Handling caught exceptions
     * @param $e
     */
    public function exceptionHandler($e): void
    {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Exception', $e->getMessage(), $e->getFile(), $e->getLine(),
            $e->getCode());
    }

    /**
     * Error logging
     * @param string $message
     * @param string $file
     * @param string $line
     */
    protected function logErrors($message = '', $file = '', $line = ''): void
    {
        error_log("[" . date('Y-m-d H:i:s') . "] Error text: {$message} | 
            File: {$file} | Line: {$line} \n=====================\n", 3,
            ROOT . '/tmp/errors.log');
    }

    /**
     * Error display
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @param int $responce
     */
    protected function displayError($errno, $errstr, $errfile, $errline, $responce = 404): void
    {
        http_response_code($responce);

        if ($responce === 404 && !DEBUG) {
            require WWW . '/errors/404.php';
            die;
        }

        if ($responce === 403 && !DEBUG) {
            require WWW . '/errors/403.php';
            die;
        }

        if (DEBUG) {
            require WWW . '/errors/dev.php';
        } else {
            require WWW . '/errors/prod.php';
        }
        die;
    }
}