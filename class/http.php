<?php

class Http {
    static private $_request;

    static public function redirect($target) {
        header('Location: ' . Config::get('host') . $target);
    }

    static private function _setRequest() {
        $host  = parse_url(Config::get('host'));
        $parts = explode('?', $_SERVER['REQUEST_URI']);
        $uri   = $parts[0];

        $called = explode('/', str_replace($host['path'] , '', $uri));

        if (!isset($called[1])) {
            Http::redirect('base/index/');
        }

        $controller = $called[0];
        $action     = $called[1];
        $params     = $_REQUEST;

        unset($called[0]);
        unset($called[1]);

        foreach (array_values($called) as $key => $value) {
            if ($key % 2 === 0) {
                $currentValue = $value;
            } else {
                if (!isset($params[$currentValue])) {
                    $params[$currentValue] = $value;
                } else {
                    if (is_array($params[$currentValue])) {
                        $params[$currentValue][] = $value;
                    } else {
                        $params[$currentValue] = [$params[$currentValue], $value];
                    }
                }
            }
        }

        self::$_request = [
            'controller' => $controller,
            'action'     => $action,
            'params'     => $params
        ];
    }

    static public function get($key = null) {
        if (!self::$_request) {
            self::_setRequest();
        }

        if ($key && !isset(self::$_request[$key])) {
            throw new Exception("Key $key unknown in Request");
        }

        return $key ? self::$_request[$key] : self::$_request;
    }
}
