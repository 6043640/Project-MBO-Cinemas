<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Reservering.php';

if (!isset($_SESSION['klant_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res_id = intval($_POST['res_id']);
    $klant_id = $_SESSION['klant_id'];

    $database = new Database();
    $conn = $database->connect();
    $reserveringObj = new Reservering($conn);

    if ($reserveringObj->annuleer($res_id, $klant_id)) {
        header('Location: mijn_reserveringen.php?success=annuleren');
        exit;
    } else {
        $error = "Fout bij het annuleren van de reservering.";
    }
} else {
    header('Location: mijn_reserveringen.php');
    exit;
}
?>