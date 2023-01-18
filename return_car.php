<?php
include_once 'classes/Database.php';
include_once 'classes/Status.php';
include_once 'classes/UserToken.php';
include_once 'classes/Car.php';
include_once 'classes/CarUser.php';
include_once 'classes/User.php';

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

if (!isset($_GET["odometer"])) {
    $status = new Status(309);
    $status->echoJson();
    return;
}

if (!isset($_GET["IBAN"])) {
    $status = new Status(305);
    $status->echoJson();
    return;
}

$carUser = new CarUser($db);
$statusCarUser = $carUser->getCarRented($status->data["user_id"], $_GET["car_id"]);
if (!$statusCarUser->isOK()) {
    $statusCarUser->echoJson();
    return;
}

$car = new Car($db);
$statusCar = $car->getOdometer($_GET["car_id"]);
if (!$statusCar->isOK()) {
    $statusCar->echoJson();
    return;
}

if ($_GET["odometer"] < $statusCar->data["odometer"]) {
    $status = new Status(310);
    $status->echoJson();
    return;
}

$statusCar = $car->setOdometer($_GET["car_id"], $_GET["odometer"]);
if (!$statusCar->isOK()) {
    $statusCar->echoJson();
    return;
}

$statusCar = $car->setState($_GET["car_id"], "vrátené zákazníkom");
if (!$statusCar->isOK()) {
    $statusCar->echoJson();
    return;
}

$statusCar = $car->getCarPrice($_GET["car_id"]);
if (!$statusCar->isOK()) {
    $statusCar->echoJson();
    return;
}

$statusCarUser = $carUser->getFinalPrice($status->data["user_id"], $_GET["car_id"], $statusCar->data["price_for_day"]);
if (!$statusCarUser->isOK()) {
    $statusCarUser->echoJson();
    return;
}

$carUser->returnCar($status->data["user_id"], $_GET["car_id"], $_GET["IBAN"], $statusCarUser->data["final_price"])->echoJson();
?>