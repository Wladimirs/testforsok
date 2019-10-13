<?php
//The entry point to the application (the Main page site).

require_once __DIR__ . '/config/init.php';
require_once LIBS . '/functions.php';
require_once CONFIG . '/routes.php';

new \testforsok\App();
