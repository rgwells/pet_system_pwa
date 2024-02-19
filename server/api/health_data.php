<?php

require_once '../inc/config.php';

include_once __DIR__ . "/../modules/ApSupport.php";
include_once __DIR__ . "/../modules/Pet.php";

use server\modules\ApSupport;
use server\modules\Pet;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $body = file_get_contents('php://input');
    $obj = json_decode($body);

    $type = $obj->type;
    if ($type == 'healing')
    {
        $amount = $obj->amount;
        $petId = $obj->petId;
        session_start ();
        $avId = $_SESSION["avId"];
        $result = ApSupport::debitSoulCoin ($avId, $amount);
        $pet = Pet::getPet($petId);
        if ($result) {
            $pet->fatigue = 0;
            $pet = Pet::savePet($pet);
        }
        $_SESSION["pet"] = $pet;

        $result = [$result, $pet];
        die (json_encode($result));
    }

}

?>