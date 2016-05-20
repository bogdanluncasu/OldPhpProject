<?php

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
        $this->load->model('unitsdb');
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
            $data['recruiting_units']=$this ->village->getRecruitUnits($_SESSION['id'],$_SESSION['current_village']);

            if (isset($_SESSION['username'])) {
                if ($_SESSION['first'] != 0) {
                    if(!isset($_GET['village'])||intval($_GET['village'])>=count($data['villages']))
                        $village=0;
                    $data['village']=$village;
                    $this->load->view("template/game/top", $data);
                    if (isset($_GET['open']) && $_GET['open'] == 'map') {
                        $this->load->view("template/game/map", $data);
                    }else if (isset($_GET['open']) && $_GET['open'] == 'barracks') {
                        $data['level_barracks'] = $data['villages'][$village]['cazarma'];
                        $data['current_units'] =
                            $this->unitsdb->get_current_units($data['villages'][$village]['id'],$_SESSION['id']);
                        $data['total_units'] =
                            $this->unitsdb->get_number_of_units($data['villages'][$village]['id'],$_SESSION['id']);
                        $this->load->view("template/game/barracks", $data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='main'){
                            $data['level_main']=$data['villages'][$village]['mainBuilding'];
                            $this->load->view("template/game/main",$data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='chat'){
                            $this->load->view("template/game/chat",$data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='farm'){
                            $data['level_farm']=$data['villages'][$village]['ferma'];
                            $this->load->view("template/game/farm.php",$data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='fair') {
                        $data['fair'] = $data['villages'][$village];
                        $this->load->view("template/game/fair.php", $data);
                    }else
                        $this->load->view("template/game/village");
                    $this->load->view("template/game/end");
                }else {
                    $this->load->view("template/game/first");
                }
            }
            
        }else $this->load->view("template/game/not_logged");
        $this->load->view("template/game/end");
        $this->load->view("template/game/footer");
    }

    public function chooseHero()
    {
        if (isset($_SESSION['username'])) {
            $this->village->create_village($this->input->post('type'));
            $this->village->create_units();
            $this->user->first($_SESSION['username']);
            echo "ok";
        }else die("<script>location.href = '/'</script>");
    }
    public function new_units($i)
    {
        if (isset($_SESSION['username'])&&isset($_POST['count'])) {
            $numberOf = $this->input->post('count');
            $villageId = $_SESSION['current_village'];
            $userId = $_SESSION['id'];

            $units = new units();
            $myunits = $units->getUnits();

            $timestamp = time() + $numberOf * $myunits[$i]['time'];
            $unitName = $myunits[$i]['name'];
            $unitPrice = $myunits[$i]['price'] * $numberOf;
            if($numberOf>0)
            $this->unitsdb->add_units($numberOf, $villageId, $userId, $timestamp, $unitName, $unitPrice);
            die("<script>location.href = '../../game?open=barracks'</script>");
        }else die("<script>location.href = '/'</script>");
    }
    public function verify()
    {
        if (isset($_SESSION['username'])) {
            $villageId = $_SESSION['current_village'];
            $userId = $_SESSION['id'];
            $this->unitsdb->verify($villageId, $userId);
            die("<script>location.href = '../../game?open=barracks'</script>");
        }else die("<script>location.href = '/'</script>");
    }
    public function logout()
    {
        if (isset($_SESSION['username'])) {
            $user = array(
                'username' => '',
                'email' => '',
                'first' => '',
                'id' => '',
            );
            $this->session->unset_userdata($user);
            $this->session->sess_destroy();
            redirect("/");
        }else die("<script>location.href = '/'</script>");
    }

}