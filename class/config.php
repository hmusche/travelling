<?php

class Config {
    static protected $_config;

    private function __construct() {}

    static public function get($key = '') {
        return $key ? self::$_config[$key] : self::$_config;
    }

    static public function set($config) {
        self::$_config = $config;
    }
}
