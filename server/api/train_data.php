<?php

//
require_once '../inc/config.php';
include_once __DIR__ . "/../modules/Train.php";

use server\modules\Train;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $body = file_get_contents('php://input');
    $obj = json_decode($body);

    $type = $obj->type;
    if ($type == 'train_list')
    {
        $train = Train::getTrainList();
        die (json_encode($train));
    }
}
?>