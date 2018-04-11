<?php

class Place {
    protected $_coll;

    public function __construct() {
        $this->_coll = MongoDb::getInstance()->getDb()->places;
    }

    public function getAll() {
        return iterator_to_array($this->_coll->find([], ['sort' => ['position' => 1]]));
    }

    public function add($place) {
        $this->_coll->insertOne($place);
    }
}
