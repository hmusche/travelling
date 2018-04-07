<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('ROOT_DIR', __DIR__);

spl_autoload_register(function($class) {
    $class = implode('/', array_map('lcfirst', explode('_', $class)));
    
    include 'class/' . $class . '.php';
});

require_once "vendor/autoload.php";

Config::set(require 'config.php');

Application::run();
