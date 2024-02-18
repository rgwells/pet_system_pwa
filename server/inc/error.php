<?php

function showError(string $title, string $heading, string $text) : void {
    include __DIR__ . "/../template/userFatalError.php";
    die();
}


function eLog (string $msg) : void
{
    error_log ($msg, 0);
}




?>