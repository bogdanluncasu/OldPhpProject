<?php


class buildingsdb extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function upgrade( $villageId, $userId, $time, $buildingName, $price)
    {

           
        
    }

    private function levelOf($building,$villageId){
        $this->db->select($building);
        $this->db->where("villageId",$villageId);
        $query = $this->db->get("tw_village");
        return $query->result()[0]->$building;

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
            case "Wise":
                $column = "Wise";
                $special = 1;
                break;
            case "Barbar":
                $column = "Barbar";
                $special = 1;
                break;
            case "Mage":
                $column = "Mage";
                $special = 1;
                break;
        }
        if ($special == 0) {
            $this->db->set($column, $column . " + " . $numberOf, FALSE);
            $this->db->where("villageId", $villageId);
            $this->db->update("tw_units");
        } else if ($special == 1) {
            if (!exists($villageId, $column)) {
                $this->db->set($column, $column . " = 1", FALSE);
                $this->db->where("villageId", $villageId);
                $this->db->update("tw_units");
            }
        }
    }

    public function get_number_of_units($villageId,$id)
    {
        $this->db->select('Alchemist,
        BeastMaster,
        Earthshaker,
        Kunkka,
        Legion_Commander,
        Tiny,
        Treant_Protector');
        $this->db->from('tw_users');
        $this->db->join('tw_village', 'tw_users.id=tw_village.userId');
        $this->db->join('tw_units', 'tw_units.villageId=tw_village.villageId');
        $this->db->where("tw_users.id", $id);
        $this->db->where("tw_village.villageId", $villageId);
        $query = $this->db->get();
        $result=0;
        foreach($query->result() as $row){
            $result+=$row->Alchemist;
            $result+=$row->BeastMaster;
            $result+=$row->Earthshaker;
            $result+=$row->Legion_Commander;
            $result+=$row->Tiny;
            $result+=$row->Treant_Protector;
            $result+=$row->Kunkka;

        }
        return $result;
    }


    public function get_current_units($villageId,$id)
    {
        $this->db->select('Alchemist,
        BeastMaster,
        Earthshaker,
        Kunkka,
        Legion_Commander,
        Tiny,
        Treant_Protector');
        $this->db->from('tw_users');
        $this->db->join('tw_village', 'tw_users.id=tw_village.userId');
        $this->db->join('tw_units', 'tw_units.villageId=tw_village.villageId');
        $this->db->where("tw_users.id", $id);
        $this->db->where("tw_village.villageId", $villageId);
        $query = $this->db->get();
        $result=array();
        foreach($query->result() as $row){
            $result['Alchemist']=$row->Alchemist;
            $result['Beast Master']=$row->BeastMaster;
            $result['Earth Shaker']=$row->Earthshaker;
            $result['Legion Commander']=$row->Legion_Commander;
            $result['Tiny']=$row->Tiny;
            $result['Treant Protector']=$row->Treant_Protector;
            $result['Kunkka']=$row->Kunkka;
        }
        return $result;

    }


    private function exists($villageId, $unitName)
    {
        $this->db->where("villageId", $villageId);
        $this->db->where($unitName, 0);
        $query = $this->db->get("tw_units");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function get_number_of_recruit_units($villageId,$userId)
    {
        $this->db->where("userId", $userId);
        $this->db->where("villageId", $villageId);
        $query = $this->db->get("tw_log_units");
        $i = 0;
        foreach ($query->result() as $row) {
            $i+=$row->numberOf;
        }
        return $i;

    }

}
