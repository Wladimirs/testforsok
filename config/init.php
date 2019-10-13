<?php
//определяем режимы работы приложения: 1 - разработки(показываем ошибки), 0 - публичный (скрываем ошибки)
define('DEBUG', 0);
//отображение корня сайта
define('ROOT', dirname(__DIR__));
//отображение публичной папки
define('WWW', ROOT . '/public');
//отображение пути к контроллерам, видам и моделям
define('APP', ROOT . '/app');
define('LIBS', ROOT . '/vendor/testforsok/core/libs');
//отображение пути к конфигу
define('CONFIG', ROOT . '/config');
//хранение шаблона сайта по умолчанию
define('LAYOUT', 'default');

//получаем в переменную $app_pass всю url-строку: https//testforsok/public/index.php
$app_pass = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
//вырезаем в ней - index.php
$app_pass = preg_replace('#[^/]+$#', '', $app_pass);
//теперь полученный url записываем в константу
define('PATH', $app_pass);

//подключим автозагрузчик composer
require_once ROOT . '/vendor/autoload.php';