<?php

//
require_once '../inc/config.php';

include_once __DIR__ . "/../modules/Partner.php";
include_once __DIR__ . "/../modules/PetOwner.php";
include_once __DIR__ . "/../modules/Habitat.php";
include_once __DIR__ . "/../modules/HabitatLocation.php";
include_once __DIR__ . "/../modules/Settings.php";

use server\modules\Partner;
use server\modules\PetOwner;
use server\modules\Habitat;
use server\modules\HabitatLocation;
use server\modules\Settings;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $body = file_get_contents('php://input');
    $obj = json_decode($body);

    //eLog ("recv: " . $body);
    $type = $obj->type;

    if ($type == 'user_location')
    {
        /*  let data = {
                type: 'user_location',
                uuid: 'uuid'
				region: 'region name',
                parcel_id: 'parcel key'
                coordinate: '<vector>'
                version: 'version string'
                url: 'prim url'
			} */

        error_log ("recv - user_location: " . json_encode($obj));
        $count = PetOwner::addLocation($obj->uuid, $obj->region, $obj->coordinate, $obj->version, $obj->parcel_id, $obj->url);
        die($count);
    }
    else if ($type == 'register_habitat')
    {
        /*
        {
            type: "register_habitat",
            reg_id: uuid
            name:  some description
            dispenser_type: "dispenser" | "affiliate" | "partner"
            habitat:  pet habitat
            region: region name
            coordinate: position
            area:  6 comma separated numbers
            parcel_id:  uuid of parcel
            texture_id: texture uuid
        }
        */

        $loc = new HabitatLocation();
        $loc->registrationId = $obj->reg_id;
        $loc->name = $obj->name;
        $loc->type = $obj->dispenser_type;
        $loc->habitatName = $obj->habitat;
        $loc->regionName = $obj->region;
        $loc->regionCoord = $obj->coordinate;
        $loc->regionArea = $obj->area;
        $loc->parcelId = $obj->parcel_id;
        $loc->textureId = $obj->texture_id;
        $loc->dispenserVersion = $obj->dispenser_version;
        $loc = HabitatLocation::putHabitatLocation($loc);

        $str = HabitatLocation::toString($loc, "~");
        die($str);
    }
    else if ($type == 'unregister_habitat')
    {
        /*
        {
            type: "unregister_habitat",
            reg_id: uuid
            dispenser_type: dispenser
            habitat: habitat type
            region: region name
            parcel_id: parcel id
        }
        */

        $flag = HabitatLocation::removeHabitatLocation ($obj->reg_id);
        die($flag);
    }
    else if ($type == 'get_habitats')
    {
        /*
        {
            type:  "get_habitats"
            region: region name
            coordinate: position
        }
        */

        $result = HabitatLocation::getHabitatsForRegion($obj->region);
        $body = "";
        $len = sizeof ($result);
        for ($i = 0; $i < $len; $i++)
        {
            $str = HabitatLocation::toString($result[$i], "~");
            if (strlen ($body)) {
                $body .= "|";
            }
            $body .= $str;
        }

        die ($body);
    }
    else if ($type == 'get_random_habitat_pic')
    {
        /*
        {
            type:  "get_random_habitat_pic"
            region: region name
        }
        */

        //eLog ("get_random_habitat_pic: " . $obj->region);
        $body = "";
        $result = HabitatLocation::getHabitatsForRegion($obj->region, 1);
        $len = sizeof ($result);
        $name = "";
        if ($len) {
            $hl = $result[0];
            $name = $hl->habitatName;
            //error_log ("habitat name: " . $name);
        }

        if ($name == "") {
            $name = "Plain";
        }

        $h = Habitat::getHabitatByName($name);
        //$body = Habitat::toString($h, "~");
        $body = json_encode($h);
        die ($body);
    }
    else if ($type == 'get_random_habitat')
    {
        /*
         {
            type: "get_random_habitat",
            habitat_type:
            count:
         }
        */

        $result = HabitatLocation::getRandomHabitat($obj->habitat_type, $obj->count);
        $body = "";
        $len = sizeof ($result);
        for ($i = 0; $i < $len; $i++)
        {
            $str = HabitatLocation::toString($result[$i], "~");
            if (strlen ($body)) {
                $body .= "|";
            }
            $body .= $str;
        }

        die ($body);
    }
    else if ($type == 'update_habitat_sl')
    {
        /*
        {
            type: "register_habitat",
            regNum:  reg id value
            slValue: some number
        }
        */

        $loc = HabitatLocation::getFirstHabitatLocationByRegNum($obj->regNum);
        $loc->slValue = ($obj->slValue ? $obj->slValue : '');
        $loc->dispenserVersion = $obj->dispenser_version;
        $loc = HabitatLocation::saveHabitatLocation($loc);
        die($loc != null);
    }
    else if ($type == 'get_random_partner_list')
    {
        /*  let data = {
                type: 'get_random_partner_list',
                count: max count of records
			} */

        $a = Partner::getRandomList ($obj->count);
        $body = "";
        $len = sizeof ($a);
        for ($i = 0; $i < $len; $i++)
        {
            $str = Partner::toString($a[$i], "~");
            if (strlen ($body)) {
                $body .= "|";
            }
            $body .= $str;
        }

        die($body);
    }
    else if ($type == 'get_settings')
    {
        /*  let data = {
                type: 'get_settings',
			} */

        $a = Settings::getSettings ();
        $body = "";
        $len = sizeof ($a);
        for ($i = 0; $i < $len; $i++)
        {
            $str = Settings::toString($a[$i], "~");
            if (strlen ($body)) {
                $body .= "|";
            }
            $body .= $str;
        }
        die ($body);
    }
    else
    {
        die ("unknown API");
    }
}

?>