<?php

abstract class Controller_Abstract {
    protected $_view;

    public function preDispatch() {
        $this->_view = View::getInstance();
        $this->_view->assign([
            'template' => 'default.phtml',
            'config'   => include('config.php'),
            'host'     => Config::get('host')
        ]);
    }

    public function postDispatch() {
        echo $this->_view->render('main.phtml');
    }
}
