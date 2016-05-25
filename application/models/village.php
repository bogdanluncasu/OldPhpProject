<?php

/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 4/1/16
 * Time: 8:28 PM
 */
class Village extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create_village($type)
    {
        if($_SESSION['first']==0) {
            $x = rand(0, 400);
            $y = rand(0, 400);
            $ok = 0;
            while ($ok == 0) {
                $this->db->where("x", $x);
                $this->db->where("y", $y);
                $query = $this->db->get("tw_village");
                if ($query->num_rows() <= 0) $ok = 1;
            }
            $data = array(
                'userId' => $_SESSION['id'],
                'gold' => 200,
                'mainBuilding' => 1,
                'cazarma' => 0,
                'ferma' => 1,
                'mina' => 1,
                'guvern' => 0,
                'targ' => 0,
                'zid' => 0,
                'type' => $type,
                'x' => $x,
                'y' => $y
            );
            $this->db->insert('tw_village', $data);
            $_SESSION['first']=1;
        }
    }
    public function create_units(){
        $this->db->where('userId',$_SESSION['id']);
        $res=$this->db->get('tw_village');
        if ($res->result()) {
            $villageId = $res->result()[0]->villageId;
            $data = array(
                'villageId' => $villageId,
                'Alchemist' => 0,
                'BeastMaster' => 0,
                'Earthshaker' => 0,
                'Kunkka' => 0,
                'Legion_Commander' => 0,
                'Tiny' => 0,
                'Treant_Protector' => 0
            );
        }
        $this->db->insert('tw_units', $data);

    }
    public function get_all_villages()
    {
        $query = $this->db->get("tw_village");
        $villages = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $village = array(
                'x' => $row->x,
                'y' => $row->y
            );
            $villages[$i] = $village;
            $i = $i + 1;
        }
        return $villages;
    }

    public function getRecruitUnits($userId,$villageId)
    {
        $this->db->where("userId", $userId);
        $this->db->where("villageId", $villageId);
        $query = $this->db->get("tw_log_units");
        $units = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $unit = array(
                'unitName' => $row->unitName,
                'timestamp' =>  $row->timestamp
            );
            $units[$i] = $unit;
            $i = $i + 1;
        }
        return $units;
    }
    public function getConstructingBuilding($userId,$villageId)
    {
        $this->db->where("userId", $userId);
        $this->db->where("villageId", $villageId);
        $query = $this->db->get("tw_log_buildings");
        $buildings = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $building = array(
                'buildingName' => $row->buildingName,
                'timestamp' =>  $row->timestamp
            );
            $buildings[$i] = $building;
            $i = $i + 1;
        }
        return $buildings;
    }


}