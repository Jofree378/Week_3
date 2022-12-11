<?php
require '../vendor/autoload.php';

//use App\Controller\User;
//use Base\Application;
//
//$app = new Application();
//$app->run();
//
//$user = new User();
//$user->indexAction();


$parts = parse_url($_SERVER['REQUEST_URI']);
var_dump($parts);

switch ($parts['path']) {
    case '/user/login':

        echo '1';
        break;
    case '/user/register':

        echo 2;
        break;
}
