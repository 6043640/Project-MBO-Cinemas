<?php
session_start();
if (!isset($_SESSION['klant_id']) || $_SESSION['rol'] !== 'medewerker') {
    header('Location: login.php');
    exit;
}
require_once '../config/database.php';
$db = (new Database())->connect();
$id = $_GET['id'] ?? 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE films SET titel = ?, genre = ?, locatie = ?, datum = ?, zaal = ?, afbeelding = ? WHERE id = ?");
    $stmt->execute([
        $_POST['titel'],
        $_POST['genre'],
        $_POST['locatie'],
        $_POST['datum'],
        $_POST['zaal'],
        $_POST['afbeelding'],
        $id
    ]);
    header('Location: medewerker_films.php');
    exit;
}
$stmt = $db->prepare("SELECT * FROM films WHERE id = ?");
$stmt->execute([$id]);
$film = $stmt->fetch();
if (!$film) {
    header('Location: medewerker_films.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Film wijzigen - MBO Cinemas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <section class="header-bar">
            <a href="index.php" class="logo" aria-label="MBO Cinemas">
                <img src="../img/mbo-cinemas-logo.png" alt="MBO Cinemas logo" class="logo-img">
            </a>
            <nav class="nav-buttons" aria-label="Hoofdmenu">
                <a href="index.php">Home</a>
                <a href="medewerker_dashboard.php">Dashboard</a>
                <a href="medewerker_films.php">Films</a>
                <a href="medewerker_reserveringen.php">Reserveringen</a>
            </nav>
            <a href="medewerker_uitloggen.php" class="login-icon" title="Uitloggen">
                <img src="../img/LoginLogo.png" alt="Uitloggen" />
            </a>
        </section>
        <section class="banner-img"></section>
    </header>
    <section class="blur-bg" aria-hidden="true"></section>
    <main>
        <section class="films-section">
            <h2 class="reserveren-title">Film wijzigen</h2>
            <div class="reserveren-wrapper">
                <form class="reserveren-form" method="post">
                    <label for="titel">Titel</label>
                    <input type="text" id="titel" name="titel" value="<?= htmlspecialchars($film['titel']) ?>" required>
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" value="<?= htmlspecialchars($film['genre']) ?>" required>
                    <label for="locatie">Locatie</label>
                    <input type="text" id="locatie" name="locatie" value="<?= htmlspecialchars($film['locatie']) ?>" required>
                    <label for="datum">Datum</label>
                    <input type="date" id="datum" name="datum" value="<?= htmlspecialchars($film['datum']) ?>" required>
                    <label for="zaal">Zaal</label>
                    <input type="text" id="zaal" name="zaal" value="<?= htmlspecialchars($film['zaal']) ?>" required>
                    <label for="afbeelding">Afbeelding (pad)</label>
                    <input type="text" id="afbeelding" name="afbeelding" value="<?= htmlspecialchars($film['afbeelding']) ?>" required>
                    <button type="submit" class="film-btn">Wijzigen</button>
                </form>
                <a href="medewerker_films.php" class="film-btn">Terug naar films</a>
            </div>
        </section>
    </main>
    <footer class='voeter'>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
</body>
</html>
