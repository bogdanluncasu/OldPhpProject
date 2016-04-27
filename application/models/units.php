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

        return array($treant_protector,$earth_shaker);
    }
}