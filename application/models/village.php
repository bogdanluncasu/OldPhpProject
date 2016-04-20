<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 4/1/16
 * Time: 8:28 PM
 */
class Village extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }
    public function create_village($type){
        $data=array(
            'userId'=>$_SESSION['id'],
            'gold'=>200,
            'mainBuilding'=>1,
            'cazarma'=>0,
            'ferma'=>1,
            'mina'=>1,
            'guvern'=>0,
            'targ'=>0,
            'zid'=>0,
            'type'=>$type

        );
        $this->db->insert('tw_village',$data);
    }


}