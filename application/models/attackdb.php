<?php

/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 4/1/16
 * Time: 8:28 PM
 */
class Attackdb extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function verify_coord($x, $y)
    {
        $this->db->where("x", $x);
        $this->db->where("y", $y);
        $query = $this->db->get("tw_village");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function verify_town($x, $y, $id)
    {

        $this->db->select("*");
        $this->db->from("tw_users");
        $this->db->join("tw_village", 'tw_users.id = tw_village.userId');
        $this->db->where("x", $x);
        $this->db->where("y", $y);
        $this->db->where ("tw_users.id", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function attack_town($x, $y, $id, $id_village)
    {
        $this->db->where("villageId", $id_village);
        $query = $this->db->get("tw_village");
        foreach ( $query->result() as $item){
            $my_x = $item->x;
            $my_y = $item->y;
        }


        $timestamp = time() + intval(sqrt (pow(($x-$my_x),2) + pow(($y - $my_y),2)));
        echo "<script>console.log(".$timestamp.")</script>";
        $data = array(
            'villageId' => $id_village,
            'timestamp' => date("Y-m-d H:i:s", $timestamp),
            'x' => $x,
            'y' => $y
        );
        $this->db->insert("tw_log_attack", $data);
    }
    public function get_all_attacks($id)
    {
        $this->db->select("*");
        $this->db->from("tw_village");
        $this->db->join("tw_users", "tw_village.userId = tw_users.id");
        $this->db->join("tw_log_attack", "tw_log_attack.villageId = tw_village.villageId");
        $this->db->where("tw_users.id", $id);
        $query = $this->db->get();
        $i = 0;
        $attacks = array();
        foreach ($query->result() as $row){
            $attack = array(
                'username' => $row->username,
                'timestamp' =>  $row->timestamp,
                'villageId' => $row->villageId,
                'x' => $row->x,
                'y' => $row->y
            );
            $attacks[$i] = $attack;
            $i = $i + 1;
        }
        return $attacks;
    }
    public function get_totalattack($id_village)
    {

        $units = new units();
        $my_units = $units->getUnits();
        $this->db->select('Alchemist,
        BeastMaster,
        Earthshaker,
        Kunkka,
        Legion_Commander,
        Tiny,
        Treant_Protector');
        $this->db->where("villageId",$id_village);
        $query = $this->db->get("tw_units");
        $result = 0;
        foreach ($query->result() as $row) {
            $result += $row->Alchemist * $my_units[0]["attack"];
            $result += $row->BeastMaster * $my_units[1]["attack"];
            $result += $row->Earthshaker * $my_units[2]["attack"];
            $result += $row->Legion_Commander * $my_units[3]["attack"];
            $result += $row->Tiny * $my_units[4]["attack"];
            $result += $row->Treant_Protector * $my_units[5]["attack"];
            $result += $row->Kunkka * $my_units[6]["attack"];
        }
        return $result;
    }
    public function final_attack($villageId, $id_attack, $units)
    {
        $total_attack = $this->get_totalattack($villageId);
        $total_attack +=($total_attack * $this->bonus_attack())/100;
        $total_defence = $this->get_totaldefence($id_attack);
        $total_defence += ($total_defence * $this->bonus_defence())/100;

        for ( $i= count($units)-1;$i>=0; $i--){
            
        }

        if( $total_attack > $total_defence) {
            $difference = $total_attack - $total_defence;
            return "Felicitari! Lupta a fost castigata!";
        }
        else {
            $difference = $total_defence - $total_attack;
            return "Ai pierdut lupta!";
        }
    }

}
