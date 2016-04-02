<?php

/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 3/30/16
 * Time: 1:07 AM
 */
Class Site extends CI_Controller
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
        $this->load->view("template/index/header");
        $this->load->view("template/index/body");
        $this->load->view("template/index/footer");
    }

    public function register(){
        $email=$this->input->post('email');
        $username=$this->input->post('username');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "2";
        }
        else if($this->user->validate($username)===false){
            echo "3";
        }else{
            $this->user->add_user();
            echo "1";
        }
    }

    public function login(){
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        if($this->user->validate($username)===true){
            echo "3";
        }else if($this->user->login($username,$password)===true){
            echo "1";
        }else{
            echo "2";
        }
    }

    
}