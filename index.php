<?php

require_once "_init.php";

$view = View::getInstance();
$view->assign([
    'template' => 'default.phtml',
    'config'   => include('config.php')
]);


echo $view->render('main.phtml');
