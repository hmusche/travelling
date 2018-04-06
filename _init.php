<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('ROOT_DIR', __DIR__);

spl_autoload_register(function($class) {
    $class = lcfirst($class);

    include 'class/' . $class . '.php';
});

require_once "vendor/autoload.php";

Config::set(require 'config.php');
