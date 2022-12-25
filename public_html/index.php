<?php
use Base\Application;
// Подключение автолоадера и конфига
require '../vendor/autoload.php';
require '../src/config.php';
require '../src/Eloquent.php';

// Запуск сайта
$app = new Application();
$app->run();
