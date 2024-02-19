<?php

//
require_once '../inc/config.php';
include_once __DIR__ . "/../modules/Food.php";

use server\modules\Food;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $body = file_get_contents('php://input');
    $obj = json_decode($body);

    $type = $obj->type;

    if (($type == 'food_cost') || ($type == 'food_list'))
    {
        $food = Food::getFoodList();
        die (json_encode($food));
    }
}
?>