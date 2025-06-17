<?php
if (!isset($_SESSION['klant_id'])) {
    header('Location: login.php');
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../config/database.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['naam']) || empty($_POST['email']) || empty($_POST['film_id']) || empty($_POST['datum']) || empty($_POST['aantal_kaartjes'])) {
        die("Vul alle velden in!");
    }

    $naam = htmlspecialchars($_POST["naam"]);
    $email = htmlspecialchars($_POST["email"]);
    $film_id = intval($_POST["film_id"]);
    $datum = htmlspecialchars($_POST["datum"]);
    $aantal_kaartjes = intval($_POST["aantal_kaartjes"]);
    $reserveringsnummer = rand(10000, 99999);
    $klant_id = isset($_SESSION['klant_id']) ? $_SESSION['klant_id'] : null;

    $stmt = $conn->prepare("INSERT INTO reserveringen (naam, email, film_id, datum, aantal_kaartjes, reserveringsnummer, klant_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$naam, $email, $film_id, $datum, $aantal_kaartjes, $reserveringsnummer, $klant_id]);

    header("Location: reservering_bevestiging.php?nummer=" . $reserveringsnummer);
    exit;
} else {
    die("Geen geldige POST-aanvraag!");
}
?>