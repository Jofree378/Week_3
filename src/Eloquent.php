<?php
namespace Base;

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
// Соединение с БД
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => DB_HOST,
    'database' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->getConnection('default')->enableQueryLog();

// Лог запросов
function printLog()
{
    $log = Capsule::connection()->getQueryLog();
    foreach ($log as $elem) {
        file_put_contents('Db/log.txt', 0.01 * $elem['time'] . ": " . $elem['query'] . 'bind: ' . json_encode($elem['bindings']) . '<br>');
    }
}