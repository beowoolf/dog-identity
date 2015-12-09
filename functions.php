<?php
include('config.inc.php');

function dbConnect() {
    global $databaseAddress, $databaseUser, $databasePass, $databaseDatabase, $databasePort;
    $mysql = new mysqli($databaseAddress, $databaseUser, $databasePass, $databaseDatabase, $databasePort);
    if ($mysql->connect_error) {
        die();
    }
    $mysql->set_charset("utf8");
    return $mysql;
}