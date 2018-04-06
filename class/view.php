<?php


class View {
    static protected $_instance;

    private function __construct() {

    }

    static public function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function assign($data) {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                continue;
            }

            $this->$key = $value;
        }
    }

    public function render($template) {
        ob_start();

        require ROOT_DIR . '/template/' . $template;

        return ob_get_clean();
    }
}
