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
        $this->db->where("tw_users.id", $id);
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
        foreach ($query->result() as $item) {
            $my_x = $item->x;
            $my_y = $item->y;
        }

        $this->db->where("villageId", $id_village);
        $this->db->set('Treant_Protector', 'Treant_Protector - ' . $units[0], FALSE);
        $this->db->set('EarthShaker', 'EarthShaker - ' . $units[1], FALSE);
        $this->db->set('BeastMaster', 'BeastMaster - ' . $units[2], FALSE);
        $this->db->set('Kunkka', 'Kunkka - ' . $units[3], FALSE);
        $this->db->set('Barbar', 'Barbar - ' . $units[4], FALSE);
        $this->db->set('Wise', 'Wise - ' . $units[5], FALSE);
        $this->db->set('Mage', 'Mage - ' . $units[6], FALSE);
        $this->db->set('Alchemist', 'Alchemist - ' . $units[7], FALSE);
        $this->db->set('Legion_Commander', 'Legion_Commander - ' . $units[8], FALSE);
        $this->db->set('Tiny', 'Tiny - ' . $units[9], FALSE);

        $this->db->update("tw_units");

        $timestamp = time() + intval(sqrt(pow(($x - $my_x), 2) + pow(($y - $my_y), 2)));
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
            'Wise' => $units[5],
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
        foreach ($query->result() as $row) {
            $attack = array(
                'username' => $row->username,
                'timestamp' => $row->timestamp,
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
        $this->db->where("villageId", $id_village);
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
        $unitsc = new units();
        $units = $unitsc->getUnits();
        $this->db->where("id", $id_attack);
        $result_c = $this->db->get("tw_log_attack");
        $c = $result_c->result()[0];
        $total_attack = $c->Treant_Protector * $units[0]['attack'] +
            $c->EarthShaker * $units[1]['attack'] +
            $c->BeastMaster * $units[2]['attack'] +
            $c->Kunkka * $units[3]['attack'] +
            $c->Barbar * $units[4]['attack'] +
            $c->Wise * $units[5]['attack'] +
            $c->Mage * $units[6]['attack'] +
            $c->Alchemist * $units[7]['attack'] +
            $c->Legion_Commander * $units[8]['attack'] +
            $c->Tiny * $units[9]['attack'];
        $this->db->where("villageId", $c->villageId);
        $result_d = $this->db->get("tw_items");
        if (count($result_d->result()) > 0)
            $total_attack += ($total_attack * $result_d->result()[0]->attackBonus) / 100;
        $total_defence = $this->get_totaldefence($id_attack);

        $this->db->from("tw_log_attack");
        $this->db->join("tw_village", "tw_log_attack.x = tw_village.x and tw_log_attack.y = tw_village.y");
        $this->db->where("id", $id_attack);
        $result_e = $this->db->get();
        $village_id = $result_e->result()[0]->villageId;

        if ($total_attack > $total_defence) {
            $difference = $total_attack - $total_defence;
            if ($c->Tiny > 0 && intval($difference / $units[9]['attack']) > 0) {
                $rest['Tiny'] = intval($difference / $units[9]['attack']);
                $difference -= $units[9]['attack'];
            } else {
                $rest['Tiny'] = 0;
            }
            if ($c->Legion_Commander > 0 && intval($difference / $units[8]['attack']) > 0) {
                $rest['Legion_Commander'] = intval($difference / $units[8]['attack']);
                $difference -= $units[8]['attack'];
            } else {
                $rest['Legion_Commander'] = 0;
            }
            if ($c->Alchemist > 0 && intval($difference / $units[7]['attack']) > 0) {
                $rest['Alchemist'] = intval($difference / $units[7]['attack']);
                $difference -= $units[7]['attack'];
            } else {
                $rest['Alchemist'] = 0;
            }
            if ($c->Mage > 0 && intval($difference / $units[6]['attack']) > 0) {
                $rest['Mage'] = intval($difference / $units[6]['attack']);
                $difference -= $units[6]['attack'];
            } else {
                $rest['Mage'] = 0;
            }
            if ($c->Wise > 0 && intval($difference / $units[5]['attack']) > 0) {
                $rest['Wise'] = intval($difference / $units[5]['attack']);
                $difference -= $units[5]['attack'];
            } else {
                $rest['Wise'] = 0;
            }
            if ($c->Barbar > 0 && intval($difference / $units[4]['attack']) > 0) {
                $rest['Barbar'] = intval($difference / $units[4]['attack']);
                $difference -= $units[4]['attack'];
            } else {
                $rest['Barbar'] = 0;
            }
            if ($c->Kunkka > 0 && intval($difference / $units[3]['attack']) > 0) {
                $rest['Kunkka'] = intval($difference / $units[3]['attack']);
                $difference -= $units[3]['attack'];
            } else {
                $rest['Kunkka'] = 0;
            }

            if ($c->BeastMaster > 0 && intval($difference / $units[2]['attack']) > 0) {
                $rest['BeastMaster'] = intval($difference / $units[2]['attack']);
                $difference -= $units[2]['attack'];
            } else {
                $rest['BeastMaster'] = 0;
            }
            if ($c->EarthShaker > 0 && intval($difference / $units[1]['attack']) > 0) {
                $rest['EarthShaker'] = intval($difference / $units[1]['attack']);
                $difference -= $units[1]['attack'];
            } else {
                $rest['EarthShaker'] = 0;
            }

            if ($c->Treant_Protector > 0 && intval($difference / $units[0]['attack']) > 0) {
                $rest['Treant_Protector'] = intval($difference / $units[0]['attack']);
                $difference -= $units[0]['attack'];
            } else {
                $rest['Treant_Protector'] = 0;
            }

            $this->update_units($c->villageId, $rest);
            $this->remove_units($village_id);
            $this->get_reward($c->villageId, $village_id, $difference);
            $this->get_report($c->villageId, $village_id, 1, $difference);

        } else {
            $difference = $total_defence - $total_attack;
            $rest = $this->get_restdefence($difference, $units);
            $this->update_defence_units($village_id, $rest);
            $this->get_report($c->villageId, $village_id, 0, $difference);
        }
        $this->db->where("id", $id_attack);
        $this->db->delete("tw_log_attack");

    }

    public function verify_alliance($x, $y)
    {
        $this->db->select("tw_users.id");
        $this->db->from("tw_users");
        $this->db->join("tw_village", "tw_users.id = tw_village.userId");
        $this->db->where("x", $x);
        $this->db->where("y", $y);
        $result = $this->db->get();
        $id = $result->result()[0]->id;
        $this->db->select("tw_users.allianceId");
        $this->db->from("tw_users");
        $this->db->join("tw_alliance", "tw_users.allianceId = tw_alliance.id");
        $this->db->where("tw_users.id", $_SESSION['id']);
        $result_a = $this->db->get();
        $allianceid = $result_a->result()[0]->allianceId;
        $this->db->where("id", $id);
        $this->db->where("allianceId", $allianceid);
        $result_b = $this->db->get("tw_users");
        if (count($result_b->result()) > 0)
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
        foreach ($result->result() as $x) {
            if ($x->timestamp <= time())
                $this->final_attack($x->id);
        }
    }

    public function get_totaldefence($id_attack)
    {
        $this->db->from("tw_log_attack");
        $this->db->join("tw_village", "tw_log_attack.x = tw_village.x and tw_log_attack.y = tw_village.y");
        $this->db->where("id", $id_attack);
        $result_e = $this->db->get();
        $village_id = $result_e->result()[0]->villageId;
        $this->db->where("villageId", $village_id);
        $result_f = $this->db->get("tw_units");
        $c = $result_f->result()[0];
        $unitsc = new units();
        $units = $unitsc->getUnits();


        $total_defence = $c->Treant_Protector * $units[0]['defense'] +
            $c->Earthshaker * $units[1]['defense'] +
            $c->BeastMaster * $units[2]['defense'] +
            $c->Kunkka * $units[3]['defense'] +
            $c->Barbar * $units[4]['defense'] +
            $c->Wise * $units[5]['defense'] +
            $c->Mage * $units[6]['defense'] +
            $c->Alchemist * $units[7]['defense'] +
            $c->Legion_Commander * $units[8]['defense'] +
            $c->Tiny * $units[9]['defense'];
        $this->db->where("villageId", $c->villageId);
        $result_d = $this->db->get("tw_items");
        if (count($result_d->result()) > 0)
            $total_defence += ($total_defence * $result_d->result()[0]->defenseBonus) / 100;
        $this->load->model("buildingsdb");
        $level_wall = $this->buildingsdb->levelOf("zid", $c->villageId);
        $total_defence += intval($level_wall * 10 + $level_wall * 10 / 6);
        return $total_defence;
    }
    public function get_restdefence($difference, $units)
    {
        $result_f = $this->db->get("tw_units");
        $c = $result_f->result()[0];
        if ($c->Tiny > 0 && intval($difference / $units[9]['defense']) > 0) {
            $rest['Tiny'] = intval($difference / $units[9]['defense']);
            $difference -= $units[9]['defense'];
        } else {
            $rest['Tiny'] = 0;
        }
        if ($c->Legion_Commander > 0 && intval($difference / $units[8]['defense']) > 0) {
            $rest['Legion_Commander'] = intval($difference / $units[8]['defense']);
            $difference -= $units[8]['defense'];
        } else {
            $rest['Legion_Commander'] = 0;
        }
        if ($c->Alchemist > 0 && intval($difference / $units[7]['defense']) > 0) {
            $rest['Alchemist'] = intval($difference / $units[7]['defense']);
            $difference -= $units[7]['defense'];
        } else {
            $rest['Alchemist'] = 0;
        }
        if ($c->Mage > 0 && intval($difference / $units[6]['defense']) > 0) {
            $rest['Mage'] = intval($difference / $units[6]['defense']);
            $difference -= $units[6]['defense'];
        } else {
            $rest['Mage'] = 0;
        }
        if ($c->Wise > 0 && intval($difference / $units[5]['defense']) > 0) {
            $rest['Wise'] = intval($difference / $units[5]['defense']);
            $difference -= $units[5]['defense'];
        } else {
            $rest['Wise'] = 0;
        }
        if ($c->Barbar > 0 && intval($difference / $units[4]['defense']) > 0) {
            $rest['Barbar'] = intval($difference / $units[4]['defense']);
            $difference -= $units[4]['defense'];
        } else {
            $rest['Barbar'] = 0;
        }
        if ($c->Kunkka > 0 && intval($difference / $units[3]['defense']) > 0) {
            $rest['Kunkka'] = intval($difference / $units[3]['defense']);
            $difference -= $units[3]['defense'];
        } else {
            $rest['Kunkka'] = 0;
        }

        if ($c->BeastMaster > 0 && intval($difference / $units[2]['defense']) > 0) {
            $rest['BeastMaster'] = intval($difference / $units[2]['defense']);
            $difference -= $units[2]['defense'];
        } else {
            $rest['BeastMaster'] = 0;
        }
        if ($c->Earthshaker > 0 && intval($difference / $units[1]['defense']) > 0) {
            $rest['EarthShaker'] = intval($difference / $units[1]['defense']);
            $difference -= $units[1]['defense'];
        } else {
            $rest['EarthShaker'] = 0;
        }

        if ($c->Treant_Protector > 0 && intval($difference / $units[0]['defense']) > 0) {
            $rest['Treant_Protector'] = intval($difference / $units[0]['defense']);
            $difference -= $units[0]['defense'];
        } else {
            $rest['Treant_Protector'] = 0;
        }
        return $rest;
    }
    public function update_units($villageId, $units)
    {
        $this->db->where("villageId", $villageId);
        $this->db->set('Treant_Protector', 'Treant_Protector + ' . $units['Treant_Protector'], FALSE);
        $this->db->set('EarthShaker', 'EarthShaker + ' . $units['EarthShaker'], FALSE);
        $this->db->set('BeastMaster', 'BeastMaster + ' . $units['BeastMaster'], FALSE);
        $this->db->set('Kunkka', 'Kunkka + ' . $units['Kunkka'], FALSE);
        $this->db->set('Barbar', 'Barbar + ' . $units['Barbar'], FALSE);
        $this->db->set('Wise', 'Wise + ' . $units['Wise'], FALSE);
        $this->db->set('Mage', 'Mage + ' . $units['Mage'], FALSE);
        $this->db->set('Alchemist', 'Alchemist + ' . $units['Alchemist'], FALSE);
        $this->db->set('Legion_Commander', 'Legion_Commander + ' . $units['Legion_Commander'], FALSE);
        $this->db->set('Tiny', 'Tiny + ' . $units['Tiny'], FALSE);

        $this->db->update("tw_units");
    }
    public function remove_units($villageId)
    {
        $this->db->where("villageId", $villageId);
        $this->db->set('Treant_Protector', 0, FALSE);
        $this->db->set('EarthShaker', 0, FALSE);
        $this->db->set('BeastMaster', 0, FALSE);
        $this->db->set('Kunkka', 0, FALSE);
        $this->db->set('Barbar', 0, FALSE);
        $this->db->set('Wise', 0, FALSE);
        $this->db->set('Mage', 0, FALSE);
        $this->db->set('Alchemist',0, FALSE);
        $this->db->set('Legion_Commander', 0, FALSE);
        $this->db->set('Tiny', 0, FALSE);

        $this->db->update("tw_units");
    }
    public function update_defence_units($villageId, $units)
    {
        $this->db->where("villageId", $villageId);
        $this->db->set('Treant_Protector', $units['Treant_Protector'], FALSE);
        $this->db->set('EarthShaker', $units['EarthShaker'], FALSE);
        $this->db->set('BeastMaster', $units['BeastMaster'], FALSE);
        $this->db->set('Kunkka', $units['Kunkka'], FALSE);
        $this->db->set('Barbar', $units['Barbar'], FALSE);
        $this->db->set('Wise',  $units['Wise'], FALSE);
        $this->db->set('Mage', $units['Mage'], FALSE);
        $this->db->set('Alchemist',  $units['Alchemist'], FALSE);
        $this->db->set('Legion_Commander', $units['Legion_Commander'], FALSE);
        $this->db->set('Tiny', $units['Tiny'], FALSE);

        $this->db->update("tw_units");
    }
    public function get_reward($villageAtt, $villageDef, $difference)
    {
        $gold = (($difference /100) % 100)/100;
        $this->db->where("villageId", $villageDef);
        $result = $this->db->get("tw_village");
        $actualgold = $result ->result()[0]->gold;

        $this->db->set("gold", "gold + ".$actualgold * $gold, FALSE);
        $this->db->where("villageId", $villageAtt);
        $this->db->update("tw_village");

        $this->db->set("gold", "gold - ".$actualgold * $gold, FALSE);
        $this->db->where("villageId", $villageDef);
        $this->db->update("tw_village");
    }
    public function get_report($villageAtt, $villageDef, $type, $difference)
    {
        $this->db->where("villageId", $villageAtt);
        $result_a = $this->db->get("tw_village");
        $this->db->where("villageId", $villageDef);
        $result_b = $this->db->get("tw_village");
        if ($type == 0)
        {
            $data_att = array (
              "villageIdAtt"=>$villageAtt,
                "villageIdDef" =>$villageDef,
                "Descriere" => "Ati pierdut lupta!",
                "userId" => $result_a -> result()[0] -> userId
            );
            $data_def = array (
                "villageIdAtt"=>$villageAtt,
                "villageIdDef" =>$villageDef,
                "Descriere" => "Ati castigat lupta!",
                "userId" => $result_b -> result()[0] -> userId
            );
            $this->db->insert("tw_reports", $data_att);
            $this->db->insert("tw_reports", $data_def);
        }
        else
        {
            $data_att = array (
                "villageIdAtt"=>$villageAtt,
                "villageIdDef" =>$villageDef,
                "Descriere" => "Ati castigat lupta!",
                "userId" => $result_a -> result()[0] -> userId
            );
            $data_def = array (
                "villageIdAtt"=>$villageAtt,
                "villageIdDef" =>$villageDef,
                "Descriere" => "Ati pierdut lupta!",
                "userId" => $result_b -> result()[0] -> userId
            );
            $this->db->insert("tw_reports", $data_att);
            $this->db->insert("tw_reports", $data_def);
        }
    }
}
