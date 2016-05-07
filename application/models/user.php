<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 4/1/16
 * Time: 8:28 PM
 */
class User extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }
    public function add_user(){
        $data=array(
            'username'=>$this->input->post('username'),
            'email'=>$this->input->post('email'),
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
        $this->db->where("username",$username);
        $query=$this->db->get("tw_users");
        if($query->num_rows()>0)return false;
        return true;
    }
    public function login($username,$password){
        $this->db->where("username",$username);
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
        $this->db->where("username",$username);
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

}