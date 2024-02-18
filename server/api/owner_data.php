<?php

//
require_once '../inc/config.php';
include_once __DIR__ . "/../modules/PetOwner.php";

use modules\PetOwner;


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
        session_start();
        $avId = $_SESSION['avId'];
        $owner = PetOwner::getOwner($avId);
        $result = $owner;
        die (json_encode($result));
    }
}
?>