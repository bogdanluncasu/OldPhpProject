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
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation', 'email'));
        $this->load->database();
        $this->load->model('user');
        $this->load->model('village');
        $this->load->model('units');
    }

    public function index()
    {
        $this->home();
    }

    private function home()
    {
        $this->load->view("template/game/header");
        if(isset($_SESSION['id'])) {
            $units=new units();
            $data['units'] = $units->getUnits();
            $data['villages'] = $this->user->get_villages($_SESSION['id']);
            $data['all_villages'] = $this->village->get_all_villages();
            $data['recruiting_units']=$this ->village->get_recruit_units($_SESSION['id']);
            $this->load->view("template/game/game", $data);
        }else $this->load->view("template/game/game");
        $this->load->view("template/game/footer");
    }

    public function chooseHero()
    {
        $this->user->first($_SESSION['username']);
        $this->village->create_village($email = $this->input->post('type'));
    }

    public function logout()
    {
        $user = array(
            'username' => '',
            'email' => '',
            'first' => '',
            'id' => '',
        );
        $this->session->unset_userdata($user);
        $this->session->sess_destroy();
        redirect("/");
    }

    public function logoutFacebook()
    {
        $user = array(
            'username' => '',
            'first' => '',
            'id' => '',
            'facebookId' => ''
        );
        $this->session->unset_userdata($user);
        $this->session->sess_destroy();
        redirect("/");
    }
}