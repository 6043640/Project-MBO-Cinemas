<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Reservering.php';


if (!isset($_SESSION['klant_id'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res_id = intval($_POST['res_id']);
    $nieuw_aantal = intval($_POST['nieuw_aantal']);
    $klant_id = $_SESSION['klant_id'];

    $database = new Database();
    $conn = $database->connect();
    $reserveringObj = new Reservering($conn);

    if ($reserveringObj->updateAantal($res_id, $nieuw_aantal, $klant_id)) {
        header('Location: mijn_reserveringen.php?success=update');
    } else {
        echo "Fout bij het bijwerken van de reservering.";
    }
} else {
    header('Location: mijn_reserveringen.php');
}
?>
