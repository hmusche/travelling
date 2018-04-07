<?php

class Controller_Api extends Controller_Abstract {
    protected $_places;
    protected $_return = [
        'status' => 'ok',
        'data'   => []
    ];


    public function getAll() {
        $this->_return['data'] = $this->_places->getAll();
    }

    public function preDispatch() {
        header('Content-Type: application/json');
        $this->_places = new Place();
    }

    public function postDispatch() {
        echo json_encode($this->_return);
    }
}
