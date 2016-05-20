<?php
class buildings
{

    public function __construct()
    {

    }
    public function getBuildings(){
        $main_building = array('name'=> "Main building",
            'max_level' => 20,
            'time' => 50,
            'image' =>"resources/graphics/buildings/MainBuilding.jpg",
            'price'=>10,
            'min_level'=>0
        );
        $barrack = array('name'=> "Barrack",
            'max_level' => 20,
            'time' => 30,
            'image' =>"resources/graphics/buildings/Barrack.jpg",
            'price'=>5,
            'min_level'=>3
        );
        $farm = array('name'=> "Farm",
            'max_level' => 20,
            'time' => 10,
            'image' =>"resources/graphics/buildings/Farm.jpg",
            'price'=>10,
            'min_level'=>0
        );
        $fair = array('name'=> "Fair",
            'max_level' => 5,
            'time' => 70,
            'image' =>"resources/graphics/buildings/Fair.jpg",
            'price'=>50,
            'min_level'=>2
        );
        $gouvernment = array('name'=> "Gouvernment",
            'max_level' => 1,
            'time' => 300,
            'image' =>"resources/graphics/buildings/Gouvernment.jpg",
            'price'=>500,
            'min_level'=>10
        );
        $wall = array('name'=> "Wall",
            'max_level' => 20,
            'time' => 30,
            'image' =>"resources/graphics/buildings/Barrack.jpg",
            'price'=>5,
            'min_level'=>1


        );
        return array($main_building,$barrack,$farm,$fair,$gouvernment,$wall);
    }
}