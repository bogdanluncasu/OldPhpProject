<?php


class buildingsdb extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function upgrade($villageId, $userId, $time, $buildingName, $price)
    {
        $this->load->model('buildings');
        $buildings = new buildings();
        $buildings = $buildings->getBuildings();



        $price= intval($price);
        foreach ($buildings as $building) {
            echo $building['name'];
            if ($buildingName == $building['name']) { echo "aisea";
                $this->db->where('villageId', $villageId);
                $res = $this->db->get('tw_village');
                $result = $res->result();
                if ($result[0]->$buildingName < $building['max_level'] && $result[0]->gold >= $price) {
                    $data = array(
                        "villageId" => $villageId,
                        "userId" => $userId,
                        "timestamp" => date("Y-m-d H:i:s", $time),
                        "buildingName" => $buildingName,
                        "type"=>1);
                    $this->db->insert("tw_log_buildings", $data);
                    $this->db->where("villageId", $villageId);
                    $this->db->set("gold", "gold-" . $price,FALSE);
                    $this->db->update("tw_village");
                }
            }
        }


    }
    public function downgrade($villageId, $userId, $buildingName)
    {
        $this->load->model('buildings');
        $buildings=new buildings();
        $buildings = $buildings->getBuildings();

        foreach($buildings as $building)
        {
            if($buildingName==$building['name'])
            {echo "asd";
                $this->db->where('villageId',$villageId);
                $res=$this->db->get('tw_village');
                $result=$res->result();
                $result = (array)($result[0]);

                if($result[$buildingName]>1){

                    $data=array(
                        "villageId"=>$villageId,
                        "userId"=>$userId,
                        "timestamp" => date("Y-m-d H:i:s", time()+1),
                        "buildingName"=>$buildingName,
                        "type"=>0);
                    $this->db->insert("tw_log_buildings", $data);

                }
            }
        }


    }

    public function levelOf($building, $villageId)
    {
        $this->db->select($building);
        $this->db->where("villageId", $villageId);
        $query = $this->db->get("tw_village");
        return $query->result()[0]->$building;

    }

    public function verify($villageId, $userId)
    {
        $this->db->where("villageId", $villageId);
        $this->db->where("userId", $userId);
        $query = $this->db->get("tw_log_buildings");
        foreach ($query->result() as $row) {
            if (strtotime($row->timestamp) - time() <= 0) {
                $this->deleteConstruct($row->id);
                $this->updateVillage($villageId, $row->buildingName, $row->type);
            }
        }
    }

    private function deleteConstruct($id)
    {
        $this->db->where("id", $id);
        $this->db->delete("tw_log_buildings");
    }

    private function updateVillage($villageId, $buildingName, $type)
    {

        if ($type == 1)
            $this->db->set($buildingName, $buildingName . " +1 ",FALSE);
        else {
            $this->db->set($buildingName, $buildingName . " -1 ",FALSE);

        }
        $this->db->where("villageId", $villageId);
        $this->db->update("tw_village");
    }

    public function getBuildings($villageId, $id)
    {
        $this->db->where("villageId", $villageId);
        $this->db->where("userId", $id);
        $buildings = $this->db->get("tw_log_buildings");
        $array = array();
        $arrays = array();
        $i = 0;
        foreach ($buildings->result() as $building) {
            $array['timestamp'] = $building->timestamp;
            $array['villageId'] = $building->villageId;
            $array['buildingName'] = $building->buildingName;
            $arrays[$i] = $array;
            $i++;
        }
        return $arrays;


    }
}