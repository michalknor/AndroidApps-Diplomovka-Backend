<?php
include_once 'classes/Database.php';
include_once 'classes/Status.php';
include_once 'classes/UserToken.php';
include_once 'classes/Car.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET["token"])) {
    $status = new Status(200);
    $status->echoJson();
    return;
}

$database = new Database();
$db = $database->getConnection(0);

$userToken = new UserToken($db);
$status = $userToken->getUserIdFromToken($_GET["token"]);

if (!$status->isOK()) {
    $status->echoJson();
    return;
}

$type = $seats = $transmission = $fuel = $powerFrom = $powerTo = "";
$page = 1;

if (isset($_GET["type"])) {
    $type = $_GET["type"];
}
if (isset($_GET["seats"])) {
    $seats = $_GET["seats"];
}
if (isset($_GET["transmission"])) {
    $transmission = $_GET["transmission"];
}
if (isset($_GET["fuel"])) {
    $fuel = $_GET["fuel"];
}
if (isset($_GET["power"])) {
    $powerFrom = explode("-", $_GET["power"])[0];
    $powerTo = explode("-", $_GET["power"])[1];
}
if (isset($_GET["page"])) {
    $page = intval($_GET["page"]);
    if ($page < 1) {
        $page = 1;
    }
}

$car = new Car($db);
$car->getCarOffer($type, $fuel, $transmission, $seats, $powerFrom, $powerTo, $page)->echoJson();
?>