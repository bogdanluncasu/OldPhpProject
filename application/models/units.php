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
            'attack'=>13,
            'defense'=>14,
            'type'=>0,
            'minlevel'=>1,
            'time'=>25,
            'image'=>"resources/graphics/units/Treant_Protector.png",
            'price'=>25
        );
        $earth_shaker = array('name'=> "Earth Shaker",
            'attack'=>21,
            'defense'=>25,
            'type'=>0,
            'minlevel'=>4,
            'time'=>50,
            'image'=>"resources/graphics/units/Earthshaker.png",
            'price'=>40
        );
        $beast_master = array('name'=> "Beast Master",
            'attack'=>30,
            'defense'=>22,
            'type'=>0,
            'minlevel'=>7,
            'time'=>120,
            'image'=>"resources/graphics/units/Beastmaster.png",
            'price'=>100
        );
        $kunkka = array('name'=> "Kunkka",
            'attack'=>48,
            'defense'=>18,
            'type'=>0,
            'minlevel'=>10,
            'time'=>210,
            'image'=>"resources/graphics/units/Kunkka.png",
            'price'=>155
        );
        $legion_commander = array('name'=> "Legion Commander",
            'attack'=>50,
            'defense'=>20,
            'type'=>2,
            'minlevel'=>15,
            'time'=>350,
            'image'=>"resources/graphics/units/Legion_Commander.png",
            'price'=>500
        );
        $tiny = array('name'=> "Tiny",
            'attack'=>50,
            'defense'=>20,
            'type'=>1,
            'minlevel'=>15,
            'time'=>350,
            'image'=>"resources/graphics/units/Tiny.png",
            'price'=>500
        );
        $alchemist = array('name'=> "Alchemist",
            'attack'=>50,
            'defense'=>20,
            'type'=>3,
            'minlevel'=>15,
            'time'=>350,
            'image'=>"resources/graphics/units/Alchemist.png",
            'price'=>500
        );
        return array($treant_protector,$earth_shaker,$beast_master,$kunkka,$legion_commander,$tiny,$alchemist);
    }
}