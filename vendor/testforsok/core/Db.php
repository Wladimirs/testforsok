<?php

namespace testforsok;

use RuntimeException;

class Db
{
    use TSingleton;

    protected function __construct()
    {
        // Obtaining database connection settings from config file
        $db = require CONFIG . '/config_db.php';

        class_alias('\RedBeanPHP\R', '\R');

        // Transfer settings for connecting to the database
        \R::setup($db['dsn'], $db['user'], $db['pass']);

        // Checking Database Connection
        if (!\R::testConnection()) {
            throw new RuntimeException('No connection to the database', 500);
        }

        // Turn on debug mode
        if (DEBUG) {
            \R::debug(true, 1);
        }
    }
}