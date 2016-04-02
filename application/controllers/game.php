<?php

/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 3/30/16
 * Time: 1:07 AM
 */
Class Game extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->library(array('session', 'form_validation', 'email'));
        $this->load->database();
        $this->load->model('user');
    }
    public function index(){
        $this->home();
    }

    private function home(){
        $this->load->view("template/game/header");
        $this->load->view("template/game/game");
        $this->load->view("template/game/footer");
    }
    public function logout(){
        $user = array(
            'username'   =>'',
            'email'  =>'',
            'first'     => '',
            'id' => '',
        );
        $this->session->unset_userdata($user);
        $this->session->sess_destroy();
        redirect("/");
    }
}