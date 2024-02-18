<?php

$host = "127.0.0.1";
$user = "u795355404_pandemonium";
$pass = "pSrL0UJcvjtMbIAGSCZo6T16YqKDCDZo";
$name = "u795355404_pandemonium";

$dbFile = __DIR__ . "/database.ini";
if (file_exists($dbFile)) {
    $data = parse_ini_file(__DIR__ . "/database.ini");

    $host = trim ($data["DB_HOST"]);
    $user = trim ($data["DB_USERNAME"]);
    $pass = trim ($data["DB_PASSWORD"]);
    $name = trim ($data["DB_DATABASE_NAME"]);
}

define ("DB_HOST", $host);  // Database host name
define ("DB_USERNAME", $user); // database user name
define ("DB_PASSWORD", $pass);  // user password
define ("DB_DATABASE_NAME", $name);  // database name
define ("DB_CHARSET", 'utf8mb4');  // encoding
const DB_DSN = 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE_NAME.';charset='.DB_CHARSET;

const DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

?>
