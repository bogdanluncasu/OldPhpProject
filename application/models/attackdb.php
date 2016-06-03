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
    public function attack_town($x, $y, $id, $id_village, $units)
    {
        $this->db->where("villageId", $id_village);
        $query = $this->db->get("tw_village");
        foreach ( $query->result() as $item){
            $my_x = $item->x;
            $my_y = $item->y;
        }

        $this->db->where("villageId", $id_village);
        $this->db->set('Treant_Protector','Treant_Protector - '.$units[0], FALSE);
        $this->db->set('EarthShaker','EarthShaker - '.$units[1],FALSE);
        $this->db->set('BeastMaster','BeastMaster - '.$units[2],FALSE);
        $this->db->set('Kunkka','Kunkka - '.$units[3],FALSE);
        $this->db->set('Barbar','Barbar - '.$units[4],FALSE);
        $this->db->set('Wise','Wise - '.$units[5],FALSE);
        $this->db->set('Mage','Mage - '.$units[6],FALSE);
        $this->db->set('Alchemist','Alchemist - '.$units[7],FALSE);
        $this->db->set('Legion_Commander','Legion_Commander - '.$units[8],FALSE);
        $this->db->set('Tiny','Tiny - '.$units[9],FALSE);

        $this->db->update("tw_units");

        $timestamp = time() + intval(sqrt (pow(($x-$my_x),2) + pow(($y - $my_y),2)));
        $data = array(
            'villageId' => $id_village,
            'timestamp' => date("Y-m-d H:i:s", $timestamp),
            'x' => $x,
            'y' => $y,
            'Treant_Protector' => $units[0],
            'EarthShaker' => $units[1],
            'BeastMaster' => $units[2],
            'Kunkka' => $units[3],
            'Barbar' => $units[4],
            'Wise' =>$units[5],
            'Mage' => $units[6],
            'Alchemist' => $units[7],
            'Legion_Commander' => $units[8],
            'Tiny' => $units[9]
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
    public function final_attack($id_attack)
    {
        $this->db->where("id", $id_attack);
        $result_c = $this->db->get("tw_log_attack");
        $current_attack = $result_c->result()[0];
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
    public function verify_alliance($x,$y)
    {
        $this->db->select("tw_users.id");
        $this->db->from("tw_users");
        $this->db->join("tw_village","tw_users.id = tw_village.userId");
        $this->db->where("x",$x);
        $this->db->where("y",$y);
        $result = $this->db->get();
        $id = $result->result()[0]->id;
        $this->db->select("tw_users.allianceId");
        $this->db->from("tw_users");
        $this->db->join("tw_alliance","tw_users.allianceId = tw_alliance.id");
        $this->db->where("tw_users.id", $_SESSION['id']);
        $result_a = $this->db->get();
        $allianceid = $result_a->result()[0]->allianceId;
        $this->db->where("id",$id);
        $this->db->where("allianceId", $allianceid);
        $result_b = $this->db->get("tw_users");
        if(count($result_b->result())>0)
            return true;
        else
            return false;
            
    }
    public function verify_time_attack($id)
    {
        $this->db->from("tw_log_attack");
        $this->db->join("tw_village", "tw_village.villageId = tw_log_attack.villageId or (tw_village.x = tw_log_attack.x and tw_village.y = tw_log_attack.y)");
        $this->db->where("tw_village.userId", $id);
        $result = $this->db->get();
        foreach ($result->result() as $x)
        {
            if($x->timestamp <= time())
                $this->final_attack($x->id);
        }
    }

}
