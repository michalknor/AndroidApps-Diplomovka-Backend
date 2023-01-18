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

$car = new Car($db);
$status2 = $car->getCar($_GET["car_id"]);
if (!$status2->isOK()) {
    $status2->echoJson();
    return $status2;
}

if (!isset($_GET["rent_to_expected"])) {
    $status = new Status(304);
    $status->echoJson();
    return;
}

if (!isset($_GET["IBAN"])) {
    $status = new Status(305);
    $status->echoJson();
    return;
}

if (!isset($_GET["birthdate"])) {
    $status = new Status(308);
    $status->echoJson();
    return;
}

$user = new User($db);
$status2 = $user->getBirthdate($status->data["user_id"], $_GET["birthdate"]);
if (!$status2->isOK()) {
    $status2->echoJson();
    return $status2;
}

$date = date( "Y-m-d", strtotime( $_GET["rent_to_expected"] ) ); 
if ($date != $_GET["rent_to_expected"]) {
    $status = new Status(306);
    $status->echoJson();
    return;
}
if (date("Y-m-d") > $_GET["rent_to_expected"]) {
    $status = new Status(307);
    $status->echoJson();
    return;
}

$carUser = new CarUser($db);
$carUser->rentCar($status->data["user_id"], $_GET["car_id"], $_GET["rent_to_expected"], $_GET["IBAN"])->echoJson();
?>