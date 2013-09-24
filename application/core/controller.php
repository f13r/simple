<?php

class Controller {

    public $model;
    public $view;

    function __construct() {
        
    }

    // действие (action), вызываемое по умолчанию
    function action_index() {
        // todo
    }

    function initView() {
        $this->view = new View();
    }

}
