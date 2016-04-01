<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 3/30/16
 * Time: 1:07 AM
 */
Class Site extends CI_Controller{
    public function index(){
        $this->home();
    }
    private function home(){
       
        $this->load->view("template/index/header");
        $this->load->view("template/index/body");
        $this->load->view("template/index/footer");
    }
}