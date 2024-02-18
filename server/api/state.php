<?php

//
require_once '../inc/config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $type = !empty($_GET["type"]) ? $_GET["type"] : 'none';

    if ($type == "state") {

        $screen = !empty($_GET["screen"]) ? $_GET["screen"] : '';
        if ($screen != "") {
            session_start();
            $_SESSION['activeScreen'] = $screen;
            die (true);
        }
    }
    else if ($type == "button") {

        $name = !empty($_GET["name"]) ? $_GET["name"] : '';
        if ($name != "") {
            session_start();
            $_SESSION['activeButton'] = $name;
            die (true);
        }
    }
    else if ($type == "food") {

        $name = !empty($_GET["name"]) ? $_GET["name"] : '';
        if ($name != "") {
            session_start();
            $_SESSION['foodName'] = $name;
            die (true);
        }
    }
    else if ($type == "train") {

        $name = !empty($_GET["name"]) ? $_GET["name"] : '';
        if ($name != "") {
            session_start();
            $_SESSION['trainName'] = $name;
            die (true);
        }
    }
    else if ($type == "quest") {

        $name = !empty($_GET["choice"]) ? $_GET["choice"] : '';
        if ($name != "") {
            session_start();
            $_SESSION['quest_choice'] = $name;
            die (true);
        }
    }
}

?>