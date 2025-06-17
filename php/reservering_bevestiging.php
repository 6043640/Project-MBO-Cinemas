<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';

$database = new Database();
$conn = $database->connect();

$reserveringsnummer = htmlspecialchars($_GET["nummer"]);

$stmt = $conn->prepare("SELECT * FROM reserveringen WHERE reserveringsnummer = ?");
$stmt->execute([$reserveringsnummer]);
$reservering = $stmt->fetch(PDO::FETCH_ASSOC);

if ($reservering) {
    // Haal filmtitel op
    $film_id = $reservering['film_id'];
    $stmt_film = $conn->prepare("SELECT titel FROM films WHERE id = ?");
    $stmt_film->execute([$film_id]);
    $film = $stmt_film->fetch(PDO::FETCH_ASSOC);
    $film_titel = $film ? htmlspecialchars($film['titel']) : "Onbekende film";

    echo "<!DOCTYPE html>
    <html lang='nl'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>MBO Cinemas - Bevestiging</title>
        <link rel='stylesheet' href='../css/style.css'>
    </head>
    <body>
        <header>
            <section class='header-bar'>
                <a href='index.php' class='logo' aria-label='MBO Cinemas'>
                    <img src='../img/mbo-cinemas-logo.png' alt='MBO Cinemas logo' class='logo-img'>
                </a>
                <nav class='nav-buttons' aria-label='Hoofdmenu'>
                    <a href='index.php'>Home</a>
                    <a href='reserveren.php'>Reserveer</a>
                    <a href='films.php'>Films</a>
                </nav>
                <a href='login.php' class='login-icon' title='Inloggen'>
                    <img src='../img/LoginLogo.png' alt='Login' />
                </a>
            </section>
        </header>
        <main>
            <section class='films-section'>
                <h2 class='reserveren-title'>Bevestiging van je reservering</h2>
                <div class='reserveren-wrapper'>
                    <p>Naam: " . htmlspecialchars($reservering['naam']) . "</p>
                    <p>E-mail: " . htmlspecialchars($reservering['email']) . "</p>
                    <p>Film: " . $film_titel . "</p>
                    <p>Datum: " . htmlspecialchars($reservering['datum']) . "</p>
                    <p>Aantal kaartjes: " . htmlspecialchars($reservering['aantal_kaartjes']) . "</p>
                    <p>Reserveringsnummer: " . htmlspecialchars($reservering['reserveringsnummer']) . "</p>
                    <a href='index.php' class='film-btn'>Terug naar home</a>
                </div>
            </section>
        </main>
        <footer class='voeter'>
            <p>&copy; 2025 MBO Cinemas</p>
        </footer>
        <script>
            localStorage.removeItem('reservering');
        </script>
    </body>
    </html>";
} else {
    echo "<p>Reservering niet gevonden.</p>";
}
?>
