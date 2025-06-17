<?php
session_start();
if (!isset($_SESSION['klant_id']) || $_SESSION['rol'] !== 'medewerker') {
    header('Location: login.php');
    exit;
}
require_once '../config/database.php';
$db = (new Database())->connect();
$stmt = $db->query("SELECT * FROM films");
$films = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Films beheren - MBO Cinemas</title>
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
            <h2 class="reserveren-title">Films beheren</h2>
            <div class="reserveren-wrapper">
                <a href="medewerker_film_toevoegen.php" class="film-btn">Film toevoegen</a>
                <table class="reserveringen-tabel">
                    <tr>
                        <th>Titel</th>
                        <th>Genre</th>
                        <th>Locatie</th>
                        <th>Datum</th>
                        <th>Zaal</th>
                        <th>Acties</th>
                    </tr>
                    <?php foreach ($films as $film): ?>
                    <tr>
                        <td><?= htmlspecialchars($film['titel']) ?></td>
                        <td><?= htmlspecialchars($film['genre']) ?></td>
                        <td><?= htmlspecialchars($film['locatie']) ?></td>
                        <td><?= htmlspecialchars($film['datum']) ?></td>
                        <td><?= htmlspecialchars($film['zaal']) ?></td>
                        <td>
                            <a href="medewerker_film_wijzigen.php?id=<?= $film['id'] ?>" class="film-btn">Wijzigen</a>
                            <a href="medewerker_film_verwijderen.php?id=<?= $film['id'] ?>" class="film-btn" onclick="return confirm('Weet je zeker dat je deze film wilt verwijderen?')">Verwijderen</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>
    </main>
    <footer class='voeter'>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
</body>
</html>
