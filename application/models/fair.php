<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 5/7/16
 * Time: 2:37 PM
 */
class fair
{

    public function __construct()
    {

    }
    public function getItems($type){

        $excalibur = array('name'=> "Excalibur Sword",
            'info'=>"Increase your attack by 10%",
            'attack'=>10,//procente
            'defense'=>0,
            'type'=>1,
            'image'=>"resources/graphics/items/warrior/1.png",
            'price'=>700
        );
        $excalibur_shield = array('name'=> "Excalibur Shield",
            'info'=>"Increase your defense by 10%",
            'attack'=>0,
            'defense'=>10,
            'type'=>1,
            'image'=>"resources/graphics/items/warrior/2.png",
            'price'=>600
        );
        $alchemist = array('name'=> "Alchemist",
            'info'=>"Recruit a Legendary Warrior : Alchemist",
            'type'=>2,
            'image'=>"resources/graphics/items/wise/1.png",
            'price'=>600
        );
        $legion_commander = array('name'=> "Legion Commander",
            'info'=>"Recruit a Legendary Warrior : Legion Commander",
            'type'=>2,
            'image'=>"resources/graphics/items/wise/2.png",
            'price'=>700
        );
        $tiny = array('name'=> "Tiny",
            'type'=>2,
            'info'=>"Recruit a Legendary Warrior : Tiny",
            'image'=>"resources/graphics/items/wise/3.png",
            'price'=>1000
        );
        $fire_amulet = array('name'=> "Fire Amulet",
            'info'=>"Increase your attack by 8% and your defense by 1%",
            'attack'=>8,//procente
            'defense'=>1,
            'getGold'=>0,
            'extraUnits'=>0,
            'type'=>3,
            'image'=>"resources/graphics/items/mage/1.png",
            'price'=>500
        );
        $nature_amulet = array('name'=> "Nature Amulet",
            'info'=>"Increase your defense by 8% and your gold earnings by 1%",
            'attack'=>0,//procente
            'defense'=>8,
            'getGold'=>1,
            'extraUnits'=>0,
            'type'=>3,
            'image'=>"resources/graphics/items/mage/2.png",
            'price'=>500
        );
        $gold_amulet = array('name'=> "Gold Amulet",
            'info'=>"Increase your attack by 2% and your gold earnings by 4%",
            'attack'=>2,//procente
            'defense'=>0,
            'getGold'=>4,
            'extraUnits'=>0,
            'type'=>3,
            'image'=>"resources/graphics/items/mage/3.png",
            'price'=>900
        );
        $yingyang_amulet = array('name'=> "YingYang Amulet",
            'info'=>"Get extra units : 10 Treants",
            'attack'=>0,//procente
            'defense'=>0,
            'getGold'=>0,
            'extraUnits'=>10,
            'type'=>3,
            'image'=>"resources/graphics/items/mage/4.png",
            'price'=>500
        );
        if($type==1)
            return array($excalibur,$excalibur_shield);
        else if($type==2)
            return array($alchemist,$legion_commander,$tiny);
        else
            return array($fire_amulet,$nature_amulet,$gold_amulet,$yingyang_amulet);
    }
}