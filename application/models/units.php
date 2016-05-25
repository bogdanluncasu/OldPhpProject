<?php

/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 4/22/16
 * Time: 7:09 PM
 */
class units
{

    public function __construct()
    {

    }
    public function getUnits(){
        $treant_protector = array('name'=> "Treant Protector",
            'attack'=>15,
            'defense'=>30,
            'type'=>0,
            'minlevel'=>1,
            'time'=>25,
            'image'=>"resources/graphics/units/Treant_Protector.png",
            'price'=>45
        );
        $earth_shaker = array('name'=> "Earth Shaker",
            'attack'=>21,
            'defense'=>25,
            'type'=>0,
            'minlevel'=>4,
            'time'=>50,
            'image'=>"resources/graphics/units/Earthshaker.png",
            'price'=>55
        );
        $beast_master = array('name'=> "Beast Master",
            'attack'=>30,
            'defense'=>21,
            'type'=>0,
            'minlevel'=>7,
            'time'=>120,
            'image'=>"resources/graphics/units/Beastmaster.png",
            'price'=>75
        );
        $kunkka = array('name'=> "Kunkka",
            'attack'=>50,
            'defense'=>18,
            'type'=>0,
            'minlevel'=>10,
            'time'=>210,
            'image'=>"resources/graphics/units/Kunkka.png",
            'price'=>125
        );
        $barbar = array('name'=> "Barbar",
            'attack'=>50,
            'defense'=>20,
            'type'=>1,
            'minlevel'=>15,
            'time'=>350,
            'image'=>"resources/1.png",
            'price'=>500
        );
        $wise = array('name'=> "Wise",
            'attack'=>50,
            'defense'=>20,
            'type'=>1,
            'minlevel'=>15,
            'time'=>350,
            'image'=>"resources/2.png",
            'price'=>500
        );
        $mage = array('name'=> "Mage",
            'attack'=>50,
            'defense'=>20,
            'type'=>1,
            'minlevel'=>15,
            'time'=>350,
            'image'=>"resources/3.png",
            'price'=>500
        );
        $alchemist = array('name'=> "Alchemist",
            'attack'=>250,
            'defense'=>45,
            'type'=>2,
            'minlevel'=>0,
            'time'=>0,
            'image'=>"resources/graphics/units/Alchemist.png",
            'price'=>400
        );
        $legion_commander = array('name'=> "Legion_Commander",
            'attack'=>250,
            'defense'=>69,
            'type'=>2,
            'minlevel'=>0,
            'time'=>0,
            'image'=>"resources/graphics/units/Legion_Commander.png",
            'price'=>600
        );
        $tiny = array('name'=> "Tiny",
            'attack'=>300,
            'defense'=>30,
            'type'=>2,
            'minlevel'=>0,
            'time'=>0,
            'image'=>"resources/graphics/units/Tiny.png",
            'price'=>650
        );
        return array($treant_protector,$earth_shaker,$beast_master,$kunkka,
            $barbar,$wise,$mage,$alchemist,$legion_commander,$tiny);
    }
}