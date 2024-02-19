<?php

//
require_once '../inc/config.php';
include_once __DIR__ . "/../modules/PetOwner.php";

use server\modules\PetOwner;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $body = file_get_contents('php://input');
    $obj = json_decode($body);

    $type = $obj->type;

    if ($type == "save_food")
    {
        session_start();
        $avId = $_SESSION['avId'];
        $owner = PetOwner::getOwner($avId);

        $owner->food += $obj->food;
        $owner = PetOwner::saveOwner($owner);
        $_SESSION["owner"] = $owner;

        $result = $owner;
        die (json_encode($result));
    }
    else if ($type == "get_owner")
    {
        $email = $obj->email;
        $avId = $obj->avId;
        $owner = PetOwner::getOwner($avId, $email);
        $result = $owner;
        die (json_encode($result));
    }
}
?>