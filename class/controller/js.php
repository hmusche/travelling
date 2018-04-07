<?php

class Controller_Js extends Controller_Abstract {
    public function main() {
        echo $this->_view->render('script.js');
        exit;
    }
}
