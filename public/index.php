<?php
use \Bootstrap\Route;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

require '../vendor/autoload.php';
require_once ('../bootstrap/app.php');
require_once ('../app/helpers/Helper.php');

session_start();

$log = new Logger('name');
$log->pushHandler(new StreamHandler('../storage/logs', Logger::WARNING));

try {
    //dd($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'], $_SERVER, $_GET, $_POST);

    $patch = explode('?', $_SERVER['REQUEST_URI'])[0];

    $route = new Route();

    $route->getAction($patch, [
        'method' => $_SERVER['REQUEST_METHOD'],
        'data' => $_REQUEST
    ]);

} catch (\Exception $exception) {
    $log->error($exception->getMessage());

    var_dump($exception->getMessage());
}


