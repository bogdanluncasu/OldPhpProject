<?php

/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 4/1/16
 * Time: 8:28 PM
 */
class Itemdb extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
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
    public function equip_items($villageId,$userId,$item,$village){
        if($village['gold']>=$item['price']) {
            if ($item['type'] == 2) {
                $column = "xxx";
                $special = 0;
                switch ($item['name']) {
                    case "Alchemist":
                        $column = "Alchemist";
                        break;
                    case "Legion Commander":
                        $column = "Legion_Commander";
                        break;
                    case "Tiny":
                        $column = "Tiny";
                        break;
                }
                if ($this->exists($villageId, $column)) {
                    $this->db->set("gold","gold - ".$item['price'],FALSE);
                    $this->db->where("villageId",$villageId);
                    $this->db->update("tw_village");
                    $this->db->set($column, 1, FALSE);
                    $this->db->where("villageId", $villageId);
                    $this->db->update("tw_units");
                }
            } else {
                if ($item['type'] == 1) {
                    $data = array(
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'attackBonus' => $item['attack'],
                        'defenseBonus' => $item['defense'],
                        'villageId' => $villageId
                    );
                } else {
                    $data = array(
                        'name' => $item['name'],
                        'skills' => "Empty",
                        'price' => $item['price'],
                        'attackBonus' => $item['attack'],
                        'defenseBonus' => $item['defense'],
                        'getGold' => $item['getGold'],
                        'extraUnits' => $item['extraUnits'],
                        'villageId' => $villageId
                    );
                }
                $this->db->where("villageId", $villageId);
                $this->db->delete("tw_items");
                $this->db->insert("tw_items", $data);
                $this->db->set("gold","gold - ".$item['price'],FALSE);
                $this->db->where("villageId", $villageId);
                $this->db->update("tw_village");
            }
        }else{
            echo "__DENIED__";
        }
    }
    public function get_equiped_item($villageId){
        $this->db->select('name');
        $this->db->from('tw_village');
        $this->db->join('tw_items','tw_items.villageId=tw_items.villageId');
        $this->db->where('tw_items.villageId',$villageId);
        $query=$this->db->get();
        $name="";
        foreach($query->result() as $row){
            $name=$row->name;
        }
        return $name;
    }
}
