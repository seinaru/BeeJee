<?php

class Controller_Admin_Panel extends Controller
{

    function __construct()
    {
        $this->model = new Model_Admin_Panel();
        $this->view = new View();

    }
    function action_index()
    {

        $this->view->generate('view_admin_panel.php', 'view_template.php'); //из главной вюхи выполнить метод ЖЕНЕРАТ
        $this->model->rewritePost();
    }
}