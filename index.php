<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('ROOT_DIR', __DIR__);

spl_autoload_register(function($class) {
    $class = strtolower($class);

    include 'class/' . $class . '.php';
});

$view = View::getInstance();
$view->assign([
    'template' => 'default.phtml',
    'config'   => include('config.php')
]);


echo $view->render('main.phtml');
