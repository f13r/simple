<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller_holdings
 *
 * @author user
 */
class Controller_Holdings extends Controller {

    public function __construct() {
        $this->model = new \Model_Holdings();
        $this->view = new View();
    }

    function action_index() {
        // доставать user_id
        $holdings = $this->model->getHoldings(2);
        $this->view->generate('holdings_view.php', 'template_view.php', $holdings);
    }

    function action_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $_POST;
            $post['user_id'] = 2;


            $result = $this->model->addHoldings($post);
            if ($result !== TRUE) {
                $result['post'] = $post;
                $this->view->generate('holdingsAdd_view.php', 'template_view.php', $result);
            } else {
                header("Location: /holdings");
            }
        } else {
            $this->view->generate('holdingsAdd_view.php', 'template_view.php');
        }
    }

   

}