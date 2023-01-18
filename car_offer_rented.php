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

$page = 1;
if (isset($_GET["page"])) {
    $page = intval($_GET["page"]);
    if ($page < 1) {
        $page = 1;
    }
}

$car = new Car($db);
$car->getCarUserOffer($status->data["user_id"], $page)->echoJson();
?>