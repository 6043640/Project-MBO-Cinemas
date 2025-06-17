<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Reservering.php';

$db = (new Database())->connect();
$reservering = new Reservering($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res_id = $_POST['res_id'];
    $aantal = $_POST['aantal'];
    $klant_id = $_SESSION['user_id'];
    if ($reservering->updateAantal($res_id, $aantal, $klant_id)) {
        header('Location: mijn_reserveringen.php?msg=success');
    } else {
        header('Location: mijn_reserveringen.php?msg=error');
    }
}