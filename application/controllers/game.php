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
        $this->load->model('attackdb');
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
                    }else if (isset($_GET['open'])&&$_GET['open']=='attack'){
                        $data['current_attacks'] = $this->attackdb->get_all_attacks($_SESSION['id']);
                        $this->load->view("template/game/attack",$data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='main'){
                            $data['level_main']=$data['villages'][$village]['mainBuilding'];
                            $this->load->view("template/game/main",$data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='government'){
                        $data['level_government']=$data['villages'][$village]['guvern'];
                        $data['current_units'] =
                            $this->unitsdb->get_current_units($data['villages'][$village]['id'],$_SESSION['id']);
                        $this->load->view("template/game/government",$data);
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
            die("<script>location.href = '../game?open=barracks'</script>");
        }else die("<script>location.href = '/'</script>");
    }
    public function verify_governers()
    {
        if (isset($_SESSION['username'])) {
            $villageId = $_SESSION['current_village'];
            $userId = $_SESSION['id'];
            $this->unitsdb->verify($villageId, $userId);
            die("<script>location.href = '../game?open=government'</script>");
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

    public function create_governors($i)
    {
        if (isset($_SESSION['username']))
        {
            $villageId = $_SESSION['current_village'];
            $userId = $_SESSION['id'];

            $units = new units();
            $myunits = $units->getUnits();

            $timestamp = time() + $myunits[$i]['time'];
            $unitName = $myunits[$i]['name'];
            $unitPrice = $myunits[$i]['price'];

            $this->unitsdb->add_governors($i, $villageId, $userId, $timestamp, $unitName, $unitPrice);
            die("<script>location.href = '../../game?open=government'</script>");
        }
    }
    public function attack()
    {
        $x = $this->input->post('x');
        $y = $this->input->post('y');
        $u0 = $this->input->post('u0');
        $u1 = $this->input->post('u1');
        $u2 = $this->input->post('u2');
        $u3 = $this->input->post('u3');
        $u4 = $this->input->post('u4');
        $u5 = $this->input->post('u5');
        $u6 = $this->input->post('u6');
        $u7 = $this->input->post('u7');
        $u8 = $this->input->post('u8');
        $u9 = $this->input->post('u9');
        $ok = 1;
        $units = $this->unitsdb->get_current_units($_SESSION['current_village'], $_SESSION['id']);
        if($units['Treant Protector']<$u0) $ok = 0;
        if($units['Earth Shaker']<$u1) $ok = 0;
        if($units['Beast Master']<$u2) $ok = 0;
        if($units['Kunkka']<$u3) $ok = 0;
        if($units['Barbar']<$u4) $ok = 0;
        if($units['Wise']<$u5) $ok = 0;
        if($units['Mage']<$u6) $ok = 0;
        if($units['Alchemist']<$u7) $ok = 0;
        if($units['Legion Commander']<$u8) $ok = 0;
        if($units['Tiny']<$u9) $ok = 0;



        if ($this->attackdb->verify_town($x,$y, $_SESSION['id'])){
            echo 3;
        }else if($this->attackdb->verify_coord($x,$y)) {
            $this->attackdb->attack_town($x,$y,$_SESSION['id'], $_SESSION['current_village']);
            echo 1;
        }
        else if($ok == 0)
            echo 4;
        else {
            echo 2;
        }
        
            
        
    }
    
   

}