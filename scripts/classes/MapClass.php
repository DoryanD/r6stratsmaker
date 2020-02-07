<?php

    class MapObj
    {
        private $NAME = "";
        private $OBJECTIVES = [""];
        private $ROOFINDEX = 0;
        private $OBJFLOOR = [0];
        
        public function __construct($str, $arr1, $k, $arr2)
        {
            $this->NAME = $str;
            $this->ROOFINDEX = $k;
            if($arr1 !== null)
            {
                $this->OBJFLOOR = $arr1;
            }
            if($arr2 !== null)
            {
                $this->OBJECTIVES = $arr2;
            }
        }
        
        public function getName()
        {
            return $this->NAME;
        }
        
        public function getObjFloor()
        {
            return $this->OBJFLOOR;
        }
        
        public function getRoofIndex()
        {
            return $this->ROOFINDEX;
        }
        
        public function getObjectives()
        {
            return $this->OBJECTIVES;
        }
    }

    //  $mapName = new MapObj('mapName', [a,b,c,d], e, [objNames01_part1<br>part2, objNames02_part...])
    //  a = highest obj, d = lowest obj, e = number of floors
    $Bank = new MapObj('Bank', [2, 1, 1, 0] , 3, ["2F Executive Lounge<br>2F CEO Office", "1F Staff Room<br>1F Open Area", "1F Tellers' Office<br>1F Archives", "B Lockers<br>B CCTV Room"]);
    $Bartlett = new MapObj('Bartlett', [1, 0, 0, 1], 2, ["2F Rowing Museum<br>2F Trophy Room", "1F Kitchen<br>1F Piano Room", "1F Reading Room<br>Library", "2F Classroom<br>Library"]);
    $Border = new MapObj('Border', [0, 0, 0, 1], 2, ["1F Custom Inspections<br>1F Supply Room", "1F Ventilation Room<br>1F Workshop", "1F Bathroom<br>1F Tellers", "2F Armory Lockers<br>2F Archives"]);
    $Chalet = new MapObj('Chalet', [2, 1, 0, 1], 3, ["2F Master Bedroom<br>2F Office", "1F Bar<br>1F Gaming Room", "B Wine Cellar<br>B Snowmile Garage", "1F Kitchen<br>1F Trophy Room"]);
    $Club_house = new MapObj('Club house', [2, 2, 1, 0], 3, ["2F Gym<br>2F Bedroom", "2F CCTV Room<br>2F Cash Room", "1F Bar<br>1F Stock Room", "B Church<br>B Arsenal Room"]);
    $Coastline = new MapObj('Coastline', [1, 1, 0, 0], 2, ["2F Hookah Lounge<br>2F Billards Room", "2F Penthouse<br>2F Theater", "1F Kitchen<br>1F Service Entrance", "1F Blue Bar<br>1F Sunrise Bar"]);
    $Consulate = new MapObj('Consulate', [2, 1, 1, 0], 3, ["2F Consul Office<br>2F Meeting Room", "1F Lobby<br>1F Press Room", "B Archives<br>1F Tellers", "B Cafeteria<br>B Garage"]);
    $Favela = new MapObj('Favela', [2, 1, 1, 0], 3, ["3F Packaging Room<br>2F Meth Lab", "2F Football Bedroom<br>2F Football Office", "2F Aunt's Bedroom<br>1F Aunt's Apartement", "1F Biker's Apartement<br>1F Biker's Bedroom"]);
    $Fortress = new MapObj('Fortress', [1, 1, 0, 0], 2, ["2F Bedroom<br>2F Commander's Office", "2F Dormitory<br>2F Briefing Room", "1F Kitchen<br>1F Cafeteria", "1F Hammam<br>1F Sitting Room"]);
    $Hereford = new MapObj('Hereford', [3, 2, 1, 0], 4, ["3F Ammo Storage<br>3F Tractor Storage", "2F Master Bedroom<br>2F Kids Bedroom", "1F Dining Room<br>1F Kitchen", "B Fermentation Chamber<br>B Brewery"]);
    $House = new MapObj('House', [2, 1, 0, -1], 3, ["2F Kid's Bedroom<br>2F Workshop", "1F Living Room<br>B Training Room", "B Training Room<br>B Garage", "DOESNT_EXIST"]);
    $Kafe = new MapObj('Kafe', [2, 1, 1, 0], 3, ["3F Bar<br>3F Cocktail Lounge", "2F Fireplace Hall<br>2F Mining Room", "2F Reading Room<br>2F Fireplace Hall", "1F Kitchen Service<br>1F Kittchen Cooking"]);
    $Kanal = new MapObj('Kanal', [3, 2, 2, 1], 4, ["CC3F Server Room<br>CC3F Control Room", "CC2F Kitchen<br>CC2F Projector Room", "CG2F Coast Guard Office<br>CG2F Holding Room", "DOESNT_EXIST"]);
    $Oregon = new MapObj('Oregon', [2, 1, 0, 2], 4, ["2F Kids Dorm<br>2F Dorm Main Hall", "1F Kitchen<br>1F Dining Hall", "B Laudry Room<br>B Supply Room", "1F Rear Stage<br>2F Watch Tower"]);
    $Outback = new MapObj('Outback', [1, 1, 0, 0], 2, ["2F Laundry<br>2F Games Room", "2F Party Room<br>2F Office", "1F Nature Room<br>1F Bushranger Room", "1F Compressor Room<br>1F Gear Store"]);
    $Plane = new MapObj('Plane', [0, 1, 2, -1], 3, ["2F Meeting Room<br>2F Executive Office", "2F Saff Secion<br>2F Executive Bedroom", "1F Cargo Hold<br>1F Luggage Hold", "DOESNT_EXIST"]);
    $Skyscraper = new MapObj('Skyscraper', [1, 1, 0, 0], 2, ["2F Karaoke<br>2F Tea Room", "2F Exhibition<br>2F Work Office", "1F BBQ<br>1F Kitchen", "1F Bedroom<br>1F Bathroom"]);
    $Theme_park = new MapObj('Theme park', [1, 1, 0, 0], 2, ["2F Initiation Room<br>2F Office", "2F Bunk<br>2F Day Care", "1F Gargoyle<br>1F Haunted Dining", "1F Drug Lab<br>1F Drug Storage"]);
    $Tower = new MapObj('Tower', [3, 2, 1, 0], 3, ["2F Gift Shop<br>2F Lantern Room", "2F Exhibit Room<br>2F Media Center", "1F Tea Room<br>1F Bar", "1F Restaurant<br>1F Bird Room"]);
    $Villa = new MapObj('Villa', [2, 2, 1, 1], 3, ["2F Aviator Room<br>2F Games Room", "2F Trophy Room<br>2F Statuary Room", "1F Living Room<br>1F Library", "1F Dining Room<br>1F Kitchen"]);
    $Yacht = new MapObj('Yacht', [3, 1, 1, 0], 4, ["4F Maps Room<br>4F Cockpit", "2F Kitchen<br>2F Engine Control", "2F Cafeteria<br>2F Staff Dormitory", "1F Server Room<br>1F Engine Storage"]);


    $mapList = [$Bank, $Bartlett, $Border, $Chalet, $Club_house, $Coastline, $Consulate, $Favela, $Fortress, $Hereford, $House, $Kafe, $Kanal, $Oregon, $Outback, $Plane, $Skyscraper, $Theme_park, $Tower, $Villa, $Yacht];
    $numberOfMaps = sizeof($mapList);

?>