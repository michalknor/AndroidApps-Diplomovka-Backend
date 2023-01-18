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

$user = new User($db);
$user->getIBAN($status->data["user_id"])->echoJson();
?>