<?php
include_once 'classes/Database.php';
include_once 'classes/Status.php';
include_once 'classes/UserToken.php';
include_once 'classes/CarUser.php';

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
$status = $carUser->getCarRented($status->data["user_id"], $_GET["car_id"]);
$status->echoJson();
?>