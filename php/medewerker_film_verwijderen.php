<?php
session_start();
if (!isset($_SESSION['klant_id']) || $_SESSION['rol'] !== 'medewerker') {
    header('Location: login.php');
    exit;
}
require_once '../config/database.php';
$db = (new Database())->connect();
$id = $_GET['id'] ?? 0;
$stmt = $db->prepare("DELETE FROM films WHERE id = ?");
$stmt->execute([$id]);
header('Location: medewerker_films.php');
exit;
?>
