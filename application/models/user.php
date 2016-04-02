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
                    'first' =>$row->first
                );
            }
            $this->session->set_userdata($user);
            return true;
        }
        return false;
    }

}