<?php

class MongoDb {
    static private $_instance;

    protected $_client;
    protected $_db;

    private function __construct() {
        $config        = Config::get('mongodb');
        $this->_client = new MongoDB\Client("mongodb://localhost:27017");
        $this->_db     = $this->_client->{$config['name']};
    }

    static public function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getDb() {
        return $this->_db;
    }
}
