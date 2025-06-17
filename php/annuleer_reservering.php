<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Reservering.php';

$db = (new Database())->connect();
$reservering = new Reservering($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res_id = $_POST['res_id'];
    $klant_id = $_SESSION['user_id'];
    if ($reservering->annuleer($res_id, $klant_id)) {
        header('Location: mijn_reserveringen.php?msg=geannuleerd');
    } else {
        header('Location: mijn_reserveringen.php?msg=error');
    }
}
