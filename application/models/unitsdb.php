<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 4/1/16
 * Time: 8:28 PM
 */
class Unitsdb extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }
    public function add_units($numberOf,$villageId,$userId,$timestamp,$unitName,$unitPrice){
        $this->db->where("villageId",$villageId);
        $this->db->where("userId",$userId);
        $myVillage=$this->db->get("tw_village");
        if($myVillage->result()) {
            if($myVillage->result()[0]->gold>=$unitPrice) {
                $this->db->where("villageId",$villageId);
                $this->db->set("gold", "gold - ".$unitPrice, FALSE);
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
    private function deleteRecruit($id){
        $this->db->where("id",$id);
        $this->db->delete("tw_log_units");
    }
    private function updateVillage($villageId,$unitName,$numberOf){
        $column="xxx";
        switch($unitName){
            case "Treant Protector":$column="Treant_Protector";break;
            case "Earth Shaker":$column="Earthshaker";break;
        }

        $this->db->set($column, $column." + ".$numberOf, FALSE);
        $this->db->where("villageId",$villageId);
        $this->db->update("tw_units");
    }
    public function verify($villageId,$userId){
        $this->db->where("villageId",$villageId);
        $this->db->where("userId",$userId);
        $query=$this->db->get("tw_log_units");
        foreach($query->result() as $row){
            if(strtotime($row->timestamp)-time()<=0){
                $this->deleteRecruit($row->id);
                $this->updateVillage($villageId,$row->unitName,$row->numberOf);
            }
        }
    }

}
