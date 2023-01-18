<?php
include_once 'classes/Database.php';
include_once 'classes/Status.php';
include_once 'classes/User.php';
include_once 'classes/UserToken.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET["username"])) {
    $status = new Status(301);
    $status->echoJson();
    return;
}

if (!isset($_GET["password"])) {
    $status = new Status(302);
    $status->echoJson();
    return;
}

$database = new Database();
$db = $database->getConnection(0);

if ($db == null) {
    $status = new Status(100);
    $status->echoJson();
    return;
}

$user = new User($db);
$statusUser = $user->getId($_GET["username"], $_GET["password"]);

if (!$statusUser->isOK()) {
    $statusUser->echoJson();
    return;
}

$userToken = new UserToken($db);
$status = $userToken->createNewToken($statusUser->data["id"]);

$status->data["fullname"] = $statusUser->data["fullname"];

$status->echoJson();
?>