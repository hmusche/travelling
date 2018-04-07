<?php

class Application {

    static public function run() {
        $controller = 'Controller_' . ucfirst(Http::get('controller'));
        $action     = Http::get('action');

        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new Exception('Action Not Found', 404);
        }

        $controller->preDispatch();
        $controller->$action();
        $controller->postDispatch();
    }
}
