<?php

/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 4/1/16
 * Time: 8:28 PM
 */
class Unitsdb extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function add_units($numberOf, $villageId, $userId, $timestamp, $unitName, $unitPrice)
    {
        $this->db->where("villageId", $villageId);
        $this->db->where("userId", $userId);
        $myVillage = $this->db->get("tw_village");
        if ($myVillage->result()) {
            if ($myVillage->result()[0]->gold >= $unitPrice) {
                $this->db->where("villageId", $villageId);
                $this->db->set("gold", "gold - " . $unitPrice, FALSE);
                $this->db->update("tw_village");
                $data = array(
                    'numberOf' => $numberOf,
                    'villageId' => $villageId,
                    'userId' => $userId,
                    'timestamp' => date("Y-m-d H:i:s", $timestamp),
                    'unitName' => $unitName
                );
                $this->db->insert('tw_log_units', $data);
            }
        };
    }

    public function verify($villageId, $userId)
    {
        $this->db->where("villageId", $villageId);
        $this->db->where("userId", $userId);
        $query = $this->db->get("tw_log_units");
        foreach ($query->result() as $row) {
            if (strtotime($row->timestamp) - time() <= 0) {
                $this->deleteRecruit($row->id);
                $this->updateVillage($villageId, $row->unitName, $row->numberOf);
            }
        }
    }

    private function deleteRecruit($id)
    {
        $this->db->where("id", $id);
        $this->db->delete("tw_log_units");
    }

    private function updateVillage($villageId, $unitName, $numberOf)
    {
        $column = "xxx";
        $special = 0;
        switch ($unitName) {
            case "Treant Protector":
                $column = "Treant_Protector";
                break;
            case "Earth Shaker":
                $column = "Earthshaker";
                break;
            case "Beast Master":
                $column = "BeastMaster";
                break;
            case "Kunkka":
                $column = "Kunkka";
                break;
            case "Legion Commander":
                $column = "Legion_Commander";
                $special = 1;
                break;
            case "Alchemist":
                $column = "Alchemist";
                $special = 1;
                break;
            case "Tiny":
                $column = "Tiny";
                $special = 1;
                break;
        }
        if ($special == 0) {
            $this->db->set($column, $column . " + " . $numberOf, FALSE);
            $this->db->where("villageId", $villageId);
            $this->db->update("tw_units");
        } else if ($special == 1) {
            if(!exists($villageId,$column)){
                $this->db->set($column, $column . " = 1", FALSE);
                $this->db->where("villageId", $villageId);
                $this->db->update("tw_units");
            }
        }
    }
    private function exists($villageId,$unitName){
        $this->db->where("villageId",$villageId);
        $this->db->where($unitName,0);
        $query=$this->db->get("tw_units");
        if($query->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }

}
