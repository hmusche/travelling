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

    public function savePlace() {
        $place = Http::get('params')['place'];

        if ($place) {
            $this->_places->add($place);
        } else {
            $this->_return['status'] = 'error';
        }
    }

    public function preDispatch() {
        header('Content-Type: application/json');
        $this->_places = new Place();
    }

    public function postDispatch() {
        echo json_encode($this->_return);
    }
}
