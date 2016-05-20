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
    public function getItems(){

        $excalibur = array('name'=> "Excalibur Sword",
            'attack'=>10,//procente
            'defense'=>0,
            'type'=>1,
            'image'=>"resources/graphics/items/warrior/1.png",
            'price'=>700
        );
        $excalibur_shield = array('name'=> "Excalibur Shield",
            'attack'=>0,
            'defense'=>10,
            'type'=>1,
            'image'=>"resources/graphics/items/warrior/2.png",
            'price'=>600
        );
        $alchemist = array('name'=> "Alchemist",
            'type'=>2,
            'image'=>"resources/graphics/items/wise/1.png",
            'price'=>600
        );
        $legion_commander = array('name'=> "Legion Commander",
            'type'=>2,
            'image'=>"resources/graphics/items/wise/2.png",
            'price'=>700
        );
        $tiny = array('name'=> "Tiny",
            'type'=>2,
            'image'=>"resources/graphics/items/wise/3.png",
            'price'=>1000
        );
        $fire_amulet = array('name'=> "Fire Amulet",
            'attack'=>8,//procente
            'defense'=>1,
            'getGold'=>0,
            'extraUnits'=>0,
            'type'=>3,
            'image'=>"resources/graphics/items/mage/1.png",
            'price'=>500
        );
        $nature_amulet = array('name'=> "Nature Amulet",
            'attack'=>0,//procente
            'defense'=>8,
            'getGold'=>0,
            'extraUnits'=>0,
            'type'=>3,
            'image'=>"resources/graphics/items/mage/2.png",
            'price'=>500
        );
        $gold_amulet = array('name'=> "Gold Amulet",
            'attack'=>1,//procente
            'defense'=>1,
            'getGold'=>2,
            'extraUnits'=>0,
            'type'=>3,
            'image'=>"resources/graphics/items/mage/3.png",
            'price'=>900
        );
        $yingyang_amulet = array('name'=> "YingYang Amulet",
            'attack'=>0,//procente
            'defense'=>0,
            'getGold'=>0,
            'extraUnits'=>1000,
            'type'=>3,
            'image'=>"resources/graphics/items/mage/4.png",
            'price'=>500
        );
        return array($excalibur,$excalibur_shield,$alchemist,$legion_commander,$tiny,$fire_amulet,$nature_amulet,$gold_amulet,$yingyang_amulet);
    }
}