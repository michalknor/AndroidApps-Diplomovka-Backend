<?php
include_once 'classes/Database.php';
include_once 'classes/Status.php';
include_once 'classes/UserToken.php';
include_once 'classes/CarUser.php';
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

if (!isset($_GET["car_id"])) {
    $status = new Status(303);
    $status->echoJson();
    return;
}
$carUser = new CarUser($db);
$statusDeposit = $carUser->getDeposit($status->data["user_id"], $_GET["car_id"]);
if (!$statusDeposit->isOK()) {
    $statusDeposit->echoJson();
    return;
}

$car = new Car($db);
$status = $car->getCar($_GET["car_id"]);
if (!$status->isOK()) {
    $status->echoJson();
    return;
}
$status->data["deposit"] = $statusDeposit->data["deposit"] . "€";

$status->echoJson();
?>