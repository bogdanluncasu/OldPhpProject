<?php
$config['sess_save_path'] = NULL;
class User extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }
    public function add_user(){
        $username=$this->input->post('username');
        $data=array(
            'username'=>htmlspecialchars($username,ENT_QUOTES,'UTF-8'),
            'email'=>htmlspecialchars($this->input->post('email'),ENT_QUOTES,'UTF-8'),
            'password'=>md5($this->input->post('password'))
        );
        $this->db->insert('tw_users',$data);
    }

    public function registerFacebook($username,$facebookId){
        $data=array(
            'username'=>$username,
            'first'=>0,
            'facebookId'=>$facebookId
        );
        $this->db->insert('tw_users',$data);
    }

    public function validate($username){
        $this->db->where("username",htmlspecialchars($username,ENT_QUOTES,'UTF-8'));
        $query=$this->db->get("tw_users");
        if($query->num_rows()>0)return false;
        return true;
    }
    public function login($username,$password){
        $this->db->where("username",htmlspecialchars($username,ENT_QUOTES,'UTF-8'));
        $this->db->where("password",md5($password));
        $query=$this->db->get("tw_users");
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $user=array(
                    'id'=>$row->id,
                    'username'=>$row->username,
                    'email'=>$row->email,
                    'first' =>$row->first,
                    'current_village'=>0
                );
            }
            $this->session->set_userdata($user);
            return true;
        }
        return false;
    }

    public function loginFacebook($username,$facebookId){
        $this->db->where("facebookId",$facebookId);
        $query=$this->db->get("tw_users");
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $user=array(
                    'id'=>$row->id,
                    'username'=>$row->username,
                    'first' =>$row->first,
                    'current_village'=>0
                );
            }
            $this->session->set_userdata($user);
        }else{
            $this->registerFacebook($username,$facebookId);
            $this->loginFacebook($username,$facebookId);
        }
    }

    public function first($username){
        $data = array(
            'first' => 1
        );
        $this->db->where("username",$username);
        $this->db->update("tw_users",$data);
        return true;
    }
    public function get_villages($userId){
        $this->db->where("userId",$userId);
        $query=$this->db->get("tw_village");
        $villages=array();
        $i = 0;
        foreach($query->result() as $row){
                $village=array(
                    'id'=>$row->villageId,
                    'gold'=>$row->gold,
                    'mainBuilding'=>$row->mainBuilding,
                    'cazarma'=>$row->cazarma,
                    'ferma'=>$row->ferma,
                    'mina'=>$row->mina,
                    'guvern'=>$row->guvern,
                    'targ'=>$row->targ,
                    'zid'=>$row->zid,
                    'type'=>$row->type,
                    'x'=>$row->x,
                    'y'=>$row->y
                );
            $villages[$i]=$village;
            $i=$i+1;
        }
        return $villages;
    }

    public function getRanking(){
        $res=$this->db->get("tw_users");
        $i=0;
        foreach($res->result() as $row){
            $this->db->where("userId",$row->id);
            $getPoints=$this->db->get("tw_village");
            $points=0;
            foreach($getPoints->result() as $row2){
                $points+=$row2->mainBuilding*2;
                $points+=$row2->cazarma*1.89;
                $points+=$row2->ferma*1.66;
                $points+=$row2->mina*1.26;
                $points+=$row2->guvern*4;
                $points+=$row2->targ*1.69;
                $points+=$row2->zid*1.25;
            }
            $user=array(
              'username'=>$row->username,
                'userId'=>$row->id,
                'points'=>$points
            );
            $users[$i]=$user;
            $i++;
        }
        return $users;
    }
    public function getAlliance($userId){
        $this->db->select("tw_alliance.id 'id',userId,nume,username");
        $this->db->from("tw_alliance");
        $this->db->join("tw_users","tw_users.allianceId=tw_alliance.id");
        $this->db->where("tw_users.id",$userId);
        $query=$this->db->get();
        $results=array();
        $i=$id=0;
        foreach ($query->result() as $row){
            $id=$row->id;
            $result["alliance"]=$row->nume;
            $result["allianceId"]=$row->id;
            $result["owner"]=$row->userId;
        }
        if($id>0) {
            $this->db->where("allianceId", $id);
            $query=$this->db->get("tw_users");
            foreach ($query->result() as $row) {
                $result["id"] = $row->id;
                $result["username"] = $row->username;
                $results[$i] = $result;
                $i++;
            }
        }
        return $results;
    }
    public function getAllianceRequests(){
        $alliances=$this->getAlliance($_SESSION['id']);
        if(count($alliances)>0) {
            if($_SESSION['id']==$alliances[0]['owner']){
                $id=$alliances[0]['allianceId'];
                $i=0;
                $results=array();
                if($id>0) {
                    $this->db->select("tw_users.id 'id',username");
                    $this->db->from("tw_users");
                    $this->db->join("tw_ally_request","tw_users.id=tw_ally_request.userId");
                    $this->db->where("tw_ally_request.allianceId", $id);
                    $query=$this->db->get();
                    foreach ($query->result() as $row) {
                        $result["id"] = $row->id;
                        $result["username"] = $row->username;
                        $results[$i] = $result;
                        $i++;
                    }
                }
                return $results;
            }else return 0;
        }
        return 0;
    }
    public function removeFromAlliance($userId){
        $alliances=$this->getAlliance($_SESSION['id']);
        if(count($alliances)>0) {
            if(($_SESSION['id']==$alliances[0]['owner']||$_SESSION['id']==$userId)&&$alliances[0]['owner']!=$userId) {
                foreach ($alliances as $ally) {
                    if($ally['id']==$userId){
                        $this->db->where("id",$userId);
                        $this->db->set("allianceId",0,FALSE);
                        $this->db->update("tw_users");
                    }
                }
            }
        }
    }
    public function addToAlliance($userId){
        $alliances=$this->getAlliance($_SESSION['id']);
        if(count($alliances)>0) {
            if($_SESSION['id']==$alliances[0]['owner']) {
                $this->db->set("allianceId",$alliances[0]['allianceId'],FALSE);
                $this->db->where("id",$userId);
                $this->db->update("tw_users");
                $this->db->where("userId",$userId);
                $this->db->delete("tw_ally_request");
            }
        }
    }
    public function removeRequestFromAlliance($userId){
        $alliances=$this->getAlliance($_SESSION['id']);
        if(count($alliances)>0) {
            if($_SESSION['id']==$alliances[0]['owner']) {
                $this->db->where("userId",$userId);
                $this->db->delete("tw_ally_request");
            }
        }
    }
    public function getAllAlliances(){
        $results=array();
        $i=0;
        $query=$this->db->query("
       Select id,nume from tw_alliance where id not in 
       (Select tw_alliance.id from tw_users join tw_ally_request on 
       tw_users.id=tw_ally_request.userId join tw_alliance on 
       tw_alliance.id=tw_ally_request.allianceId where tw_users.id=".$_SESSION['id'].")");
        foreach ($query->result() as $row) {
            $result["id"] = $row->id;
            $result["name"] = $row->nume;
            $results[$i] = $result;
            $i++;
        }
        return $results;
    }
    public function applyToAlliance($allyId){
        $alliances=$this->getAlliance($_SESSION['id']);
        if(count($alliances)==0) {
            $this->db->where("userId",$_SESSION['id']);
            $this->db->where("allianceId",$allyId);
            $res=$this->db->get("tw_ally_request");
            if($res->num_rows()==0) {
                $data = array(
                    'userId' => $_SESSION['id'],
                    'allianceId' => $allyId
                );
                $this->db->insert("tw_ally_request", $data);
            }
        }
    }
    public function createAlliance($name){
        $alliances=$this->getAlliance($_SESSION['id']);
        if(count($alliances)==0) {
            $this->db->where("nume",$name);
            $res=$this->db->get("tw_alliance");
            if($res->num_rows()==0&&strlen($name)>0) {
                $this->db->where("userId",$_SESSION['id']);
                $this->db->delete("tw_ally_request");
                $data = array(
                    'userId' => $_SESSION['id'],
                    'nume' => htmlspecialchars($name,ENT_QUOTES,'UTF-8')
                );
                $this->db->insert("tw_alliance", $data);
                $this->db->where("userId",$_SESSION['id']);
                $all=$this->db->get("tw_alliance");
                $allyId=0;
                foreach ($all->result() as $row) {
                    $allyId=$row->id;
                }
                $this->db->set("allianceId",$allyId,FALSE);
                $this->db->where("id",$_SESSION['id']);
                $this->db->update("tw_users");
                echo 1;
            }else{
                echo 2;
            }
        }
    }
    public function abolishAlliance($id){
        $alliances=$this->getAlliance($_SESSION['id']);
        if(count($alliances)>0) {
            if($_SESSION['id']==$alliances[0]['owner']&&$id==$alliances[0]['allianceId']) {
                $this->db->set("allianceId",0,FALSE);
                $this->db->where("allianceId",$id);
                $this->db->update("tw_users");
                $this->db->where("allianceId",$id);
                $this->db->delete("tw_ally_request");
                $this->db->where("id",$id);
                $this->db->delete("tw_alliance");
            }
        }
    }
    public function getVillages($id){
        $this->db->where("userId",$id);
        $res=$this->db->get("tw_village");
        return $res->result();
        
    }

}
