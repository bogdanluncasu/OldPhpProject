<?php

Class Game extends CI_Controller
{
    var $village;
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
        $this->load->model('fair');
        $this->load->model('itemdb');
        $this->load->model('buildings');
    }
    function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $file = 'logs.txt';
        $current = file_get_contents($file);
        $current .= $errstr."\n";
        file_put_contents($file, $current);
    }
    public function index()
    {
        set_error_handler(array('self','errorHandler'),E_ALL);
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
                    else $village=intval($_GET['village']);
                    $this->village->verify_stats($data['villages'][$village]['id'],$data['villages'][$village]['ferma']);
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
                            $buildings=new buildings();
                            $data['buildings']=$buildings->getBuildings();
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
                        $fair=new fair();
                        $data['current_units'] =
                            $this->unitsdb->get_current_units($data['villages'][$village]['id'],$_SESSION['id']);
                        $data['fair'] = $data['villages'][$village];
                        $data['items']=$fair->getItems($data['fair']['type']);
                        $data['equiped']=$this->itemdb->get_equiped_item($data['villages'][$village]['id']);
                        $this->load->view("template/game/fair.php", $data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='ranking') {
                        function cmp($a, $b)
                        {
                            return $a["points"] > $b["points"];
                        }
                        $data['users'] = $this->user->getRanking();
                        usort($data['users'], "cmp");
                        $data['users']=array_reverse($data['users']);
                        $this->load->view("template/game/ranking.php", $data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='villages') {
                        $this->load->view("template/game/villages.php", $data);
                    }else if (isset($_GET['open'])&&$_GET['open']=='alliance') {
                        $data['alliance']=$this->user->getAlliance($_SESSION['id']);
                        $data['request']=$this->user->getAllianceRequests();
                        if(count($data['alliance'])==0){
                            $data['allAlliances']=$this->user->getAllAlliances();
                        }
                        $this->load->view("template/game/alliance.php", $data);
                    }else
                        $this->load->view("template/game/village");
                    //$this->load->view("template/game/end");
                }else {
                    $this->load->view("template/game/first");
                }
            }
            
        }else $this->load->view("template/game/not_logged");
        $this->load->view("template/game/end");
        $this->load->view("template/game/footer");
    }
    public function getRankings(){
        if(isset($_SESSION['username'])){
            $users=$this->user->getRanking();
            function cmp($a, $b)
            {
                return $a["points"] > $b["points"];
            }
            usort($users, "cmp");
            echo json_encode(array_values(array_reverse($users)));
        }
    }
    public function removeFromAlliance(){
        if(isset($_SESSION['username'])){
            $id=$this->input->post("id");
            $this->user->removeFromAlliance($id);
        }
    }
    public function addToAlliance(){
        if(isset($_SESSION['username'])){
            $id=$this->input->post("id");
            $this->user->addToAlliance($id);
        }
    }
    public function applyToAlliance(){
        if(isset($_SESSION['username'])){
            $id=$this->input->post("id");
            $this->user->applyToAlliance($id);
        }
    }
    public function abolishAlliance(){
        if(isset($_SESSION['username'])){
            $id=$this->input->post("id");
            $this->user->abolishAlliance($id);
        }
    }
    public function createAlliance(){
        if(isset($_SESSION['username'])){
            $name=$this->input->post("name");
            $this->user->createAlliance($name);
        }
    }
    public function removeRequestFromAlliance(){
        if(isset($_SESSION['username'])){
            $id=$this->input->post("id");
            $this->user->removeRequestFromAlliance($id);
        }
    }
    public function chooseHero()
    {
        if (isset($_SESSION['username'])) {
            $this->village->create_village($this->input->post('type'));
            $this->village->create_units();
            $this->village->create_stats();
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
            $this->set_village();
            die("<script>location.href = '../../game?open=barracks&village=".$this->village."'</script>");
        }else die("<script>location.href = '/'</script>");
    }
    
    public function equipItem(){
        if (isset($_SESSION['username'])) {
            $this->load->model('itemdb');
            $villages=$this->user->get_villages($_SESSION['id']);
            if(!isset($_GET['village'])||intval($_GET['village'])>=count($villages))
                $village=0;
            else $village=$_GET['village'];
            $item = $this->input->post('item');
            $villageId = $villages[$village]['id'];
            $userId = $_SESSION['id'];
            if($villages[$village]['type']==$item['type'])
            $this->itemdb->equip_items($villageId, $userId,$item,$villages[$village]);
            echo "OK";
        }else die("<script>location.href = '/'</script>");
    }
    
    public function verify()
    {
        if (isset($_SESSION['username'])) {
            $villageId = $_SESSION['current_village'];
            $userId = $_SESSION['id'];
            $this->unitsdb->verify($villageId, $userId);
            $this->set_village();
            die("<script>location.href = '../game?open=barracks&village=".$this->village."'</script>");
        }else die("<script>location.href = '/'</script>");
    }
    public function verify_governers()
    {
        if (isset($_SESSION['username'])) {
            $villageId = $_SESSION['current_village'];
            $userId = $_SESSION['id'];
            $this->unitsdb->verify($villageId, $userId);
            $this->set_village();
            die("<script>location.href = '../game?open=government&village=".$this->village."'</script>");
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
    public function set_village(){
        if(!isset($_GET['village'])||intval($_GET['village'])>=count($this->user->get_villages($_SESSION['id'])))
            $village=0;
        else $village=$_GET['village'];
        $this->village=$village;
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
            $this->set_village();
            die("<script>location.href = '../../game?open=government&village=".$this->village."'</script>");
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
        else if($units['Earth Shaker']<$u1) $ok = 0;
        else if($units['Beast Master']<$u2) $ok = 0;
        else if($units['Kunkka']<$u3) $ok = 0;
        else if($units['Barbar']<$u4) $ok = 0;
        else if($units['Wise']<$u5) $ok = 0;
        else if($units['Mage']<$u6) $ok = 0;
        else if($units['Alchemist']<$u7) $ok = 0;
        else if($units['Legion Commander']<$u8) $ok = 0;
        else if($units['Tiny']<$u9) $ok = 0;
        else if($u0+$u1+$u2+$u3+$u4+$u5+$u6+$u7+$u8+$u9==0)$ok=0;

        if($ok == 0)
            echo 4;
        else if ($this->attackdb->verify_town($x,$y, $_SESSION['id'])){
            echo 3;
        }else if($this->attackdb->verify_coord($x,$y)) {
            $this->attackdb->attack_town($x, $y, $_SESSION['id'], $_SESSION['current_village']);
            echo 1;
        }else {
            echo 2;
        }
    }
    
   

}