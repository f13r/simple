<?php

class Controller_Account extends Controller {

    public function __construct() {
        $this->model = new Model_Account();
    }

    function action_index() {
        $this->view->result = 'Hello!';
    }

    function action_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $_POST;

            $result = $this->model->addUser($post);
            if ($result !== TRUE) {
                $result['post'] = $post;
                $this->view->generate('account_view.php', 'template_view.php', $result);
            } else {
                header("Location: /account/login");
            }
        }
    }

    function action_login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $_POST;
            if ($this->model->login($post)) {
                header("Location: /holdings/");
            } else {
                $data = array();
                $data['error'] = 'Не верный E-mail или пароль';
                $data['post'] = $post;
                $this->view->generate('login_view.php', 'templateLogin_view.php', $data);
            }
        } else {

            $this->view->generate('login_view.php', 'templateLogin_view.php');
        }
    }

}
