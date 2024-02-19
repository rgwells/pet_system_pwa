<?php

require_once '../inc/config.php';
require_once '../modules/ApSupport.php';
require_once '../modules/PetOwner.php';

use server\modules\ApSupport;
use server\modules\PetOwner;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $body = file_get_contents('php://input');
    $obj = json_decode($body);

    $type = $obj->type;
    if ($type == 'buy_ap')
    {
        $amount = $obj->amount;
        $avId = $obj->avId;
        $owner = PetOwner::getOwner($avId);
        $result = "0";
        if (($owner->id != 0) && ($amount >= 10)) {
            $result = ApSupport::debitSoulCoin($avId, $amount);
            $owner->actionPoints += $amount * 0.0050;
            $owner = PetOwner::saveOwner($owner);
        }

        die (json_encode($result));
    }
}

?>