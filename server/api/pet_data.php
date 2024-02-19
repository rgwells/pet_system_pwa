<?php
//
require_once '../inc/config.php';
include_once __DIR__ . "/../modules/LocationRequest.php";
include_once __DIR__ . "/../modules/Pet.php";
include_once __DIR__ . "/../modules/PetActivity.php";
include_once __DIR__ . "/../modules/PetOwner.php";
include_once __DIR__ . "/../modules/PetSpecies.php";
include_once __DIR__ . "/../modules/Saying.php";
include_once __DIR__ . "/../modules/WildPet.php";

use server\modules\LocationRequest;
use server\modules\Pet;
use server\modules\PetOwner;
use server\modules\PetActivity;
use server\modules\PetTemplate;
use server\modules\Saying;
use server\modules\WildPet;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $type = !empty($_GET["type"]) ? $_GET["type"] : 'none';

    if ($type == "get") {
        $petId = !empty($_GET["pet_id"]) ? $_GET["pet_id"] : '';
        $idx = $_GET["index"];

        // example http://localhost:8080/pet/api/pet_data.php?pet_id=1
        if ((strlen($petId)) && (strlen($idx))) {
            session_start();
            $_SESSION["page_offset"] = (int)$idx;

            $pet = Pet::getPet((int)$petId);
            $_SESSION['pet'] = $pet;

            $result = json_encode($pet, JSON_PRETTY_PRINT);
            die ($result);
        }
    }
    else if ($type == "get_pet_list")
    {
        session_start ();
        $avId = $_SESSION['avId'];
        $pageNum = !empty($_GET["current_page"]) ? $_GET["current_page"] : 0;
        $attribFilter = $_SESSION["attrib_filter"];
        $petList = PetOwner::getPetList($avId, $pageNum, $attribFilter);
        $result = json_encode($petList, JSON_PRETTY_PRINT);
        die ($result);
    }
    else if ($type == "get_wild_pet")
    {
        session_start ();
        $owner = PetOwner::getOwner($_SESSION['avId']);
        $wildPet = WildPet::getRandomWildPetForRegion($owner->region, $owner->coord);
        $_SESSION['wildPet'] = $wildPet;
        $result = json_encode($wildPet, JSON_PRETTY_PRINT);
        die ($result);
    }
    else if ($type == "filter")
    {
        $attr = !empty($_GET["attr"]) ? $_GET["attr"] : 'none';

        // redo pet list with attribute filter
        session_start();
        $avId = $_SESSION["avId"];
        $oldFilter = $_SESSION["attrib_filter"];
        $_SESSION["attrib_filter"] = $attr;
        if ($oldFilter != $attr) {
            $_SESSION['page_offset'] = 0;
            $_SESSION['page_page'] = 0;
        }

        $petList = PetOwner::getPetList($avId, 0, $attr);
        $result = json_encode($petList, JSON_PRETTY_PRINT);
        die ($result);
    }
    else if ($type == "delete_pet")
    {
        $petId = !empty($_GET["pet_id"]) ? $_GET["pet_id"] : '-1';

        $ok = Pet::deletePet($petId);
        if ($ok)
        {
            session_start();
            $avId = $_SESSION["avId"];
            $attribFilter = $_SESSION["attrib_filter"];
            $total = Pet::getPetCountForOwner($avId, $attribFilter);
            $pet = Pet::getFirstPetByOwner($avId, $attribFilter);

            $_SESSION["page_total"] = $total;
            $_SESSION["page_offset"] = -1;
            $_SESSION["pet"] = $pet;

            $result = [$ok, $pet];
            die (json_encode($result));
        }
        else
        {
            die ($ok);
        }
    }
    else if ($type == "page")
    {
        session_start ();
        $avId = $_SESSION["avId"];
        $pageNum = !empty($_GET["current_page"]) ? $_GET["current_page"] : 0;
        $pageIncrement = !empty($_GET["page_inc"]) ? $_GET["page_inc"] : 1;
        $attribFilter = $_SESSION["attrib_filter"];

        $petTotal = Pet::getPetCountForOwner($avId, $attribFilter);

        $thePage = (int) floor ($pageNum + $pageIncrement);


        if ($thePage > ($petTotal / PETS_PER_PAGE) - 1)  $thePage = 0;
        if ($thePage < 0) $thePage = 0;

        $thePage = (int) floor ($thePage);
        error_log ("page " . $thePage);

        // update session settings
        $_SESSION["page_page"] = $thePage;
        $_SESSION["page_offset"] = 0;
        $_SESSION["page_total"] = $petTotal;

        $pList = PetOwner::getPetList($avId, $thePage, $attribFilter);
        $result = [$thePage, $pList ];
        die (json_encode($result));
    }
    else if ($type == "get_saying")
    {
        $category = !empty($_GET["category"]) ? $_GET["category"] : 'none';
        $saying = Saying::getRandomSaying($category);
        $result = $saying;
        die (json_encode($result));
    }
    else
    {
        die ("Pandemonium Pet System API");
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $body = file_get_contents('php://input');
    $obj = json_decode($body);

    $type = $obj->type;

    if ($type == 'save_stats')
    {
        $petId = $obj->petId;

        $pet = Pet::getPet($petId);
        $pet->constitution += $obj->constitution;
        $pet->strength += $obj->strength;
        $pet->agility += $obj->agility;
        $pet->charm += $obj->charm;
        $pet->confidence += $obj->confidence;
        $pet->empathy += $obj->empathy;
        $pet->intelligence += $obj->intelligence;
        $pet->wisdom += $obj->wisdom;
        $pet->sorcery += $obj->sorcery;
        $pet->loyalty += $obj->loyalty;
        $pet->spirituality += $obj->spirituality;
        $pet->karma += $obj->karma;
        $pet->fatigue += $obj->fatigue;

        $pet = Pet::savePet($pet);

        session_start ();
        $avId = $_SESSION['avId'];
        if (! $obj->cost)   $obj->cost = 0;
        $owner = PetOwner::getOwner($avId);
        $owner->food += $obj->cost;
        $owner->actionPoints += $obj->actionPoints;
        $owner = PetOwner::saveOwner($owner);
        $_SESSION['owner'] = $owner;
        $_SESSION['pet'] = $pet;

        $result = [$pet, $owner];
        die (json_encode($result));
    }
    else if ($type == 'save_pet_owner')
    {
        $petId = $obj->id;
        session_start ();
        $avId = $_SESSION['avId'];

        if (! $petId) {
            $obj->id = 0;
            $obj->owner = $avId;
            // set up new pet number
            $obj->petNumber = Pet::getNextPetNumber() + 1;
            $pet = Pet::putPet($obj);
        }
        else
        {
            // note the isWild flag is set to false on save automatically
            $pet = Pet::getPet($petId);

            $pet->owner = $avId;
            // set up new pet number
            $pet->petNumber = Pet::getNextPetNumber() + 1;
            $pet = Pet::savePet($pet);
        }

        // refresh the owner since the pet count may have changes.
        $owner = PetOwner::getOwner($avId);
        $result = [$pet, $owner];
        die (json_encode($result));
    }
    else if ($type == 'save_rest')
    {
        $avId = $obj->avId;
        $fatigueAmt = $obj->fatigue;
        $actionPts = $obj->actionPts;
        $petId = $obj->petId;

        $result = Pet::restPets($avId, $fatigueAmt, $actionPts);
        $owner = PetOwner::getOwner($avId);
        $pet = Pet::getPet($petId);
        $_SESSION['owner'] = $owner;
        $_SESSION['pet'] = $pet;

        $result = [$pet, $owner];
        die (json_encode($result));
    }
    else if ($type == 'do_vacation')
    {
        $pet = Pet::getPet($obj->petId);
        $pet->fatigue += $obj->fatigue;
        $pet = Pet::savePet($pet);
        session_start();


        $owner = PetOwner::getOwner($obj->avId);
        $owner->food += $obj->food;
        $owner = PetOwner::saveOwner($owner);
        $_SESSION['pet'] = $pet;
        $_SESSION['owner'] = $owner;

        $result = [$pet, $owner];
        die (json_encode($result));
    }
    else if ($type == 'save_activity')
    {
        session_start ();

        $result = PetActivity::addActivity ($obj->petId, $obj->activity);
        if ($obj->activity == "quest")
        {
            // HACK for testing.
            //// put the avatar id in the request data
            if (! $_SESSION['avId'] )
            {
                $av = $obj->avId;
            }
            else
            {
                $av = $_SESSION['avId'];
            }
            // user pressed the quest button
            $owner = PetOwner::getOwner($av);

            try {
                if ($owner->primUrl != "") {
                    $resp = LocationRequest::makeRequest($owner->primUrl, $av);
                    if ($resp != "Ok") {
                        eLog("Error calling url: " . $owner->primUrl . ", error: " . substr ($resp, 0, 64));
                    }
                    else {
                        eLog("Success calling url: " . $owner->primUrl);
                    }
                }
            }
            catch (Exception $e)
            {
                eLog("Exception: " . $e);
            }
        }

        die (json_encode($result));
    }
    else if ($type == 'generate_wild_pets')
    {
        //WildPet::generateWildPets(PetSpecies::$specieNames, "Common");
        die (json_encode(true));
    }
    else if ($type == 'buy_new_pet')
    {
        $result = FALSE;
        $owner = PetOwner::getOwner($obj->avId);

        if ($owner->totalPets < MAX_PLAYER_PETS)
        {
            $petTemplate = PetTemplate::getPetTemplate("Bryony");
            if ($petTemplate) {
                $pet = Pet::cloneFromTemplate($petTemplate, "Common", $obj->avId);
                if ($pet->id) {
                    $result = TRUE;
                }
            }
        }

        die (json_encode($result));
    }
    else if ($type == 'get_pet')
    {
        $result = FALSE;

        $petId = $obj->petId;
        $av = $obj->avId;

        $pet = null;

        if ($petId > 0)
        {
            $pet = Pet::getPet((int)$petId);
        }
        else
        {
            if ($av) {
                $pet = Pet::getFirstPetByOwner($av, 'none');
            }
        }

        $_SESSION['pet'] = $pet;

        $result = json_encode($pet, JSON_PRETTY_PRINT);
        die ($result);
    }

}

?>
