<?php
session_start();
if (!isset($_SESSION['klant_id']) || $_SESSION['rol'] !== 'medewerker') {
    header('Location: login.php');
    exit;
}
require_once '../config/database.php';
$db = (new Database())->connect();
$stmt = $db->query("
    SELECT 
        f.titel,
        f.datum,
        f.locatie,
        f.zaal,
        COALESCE(SUM(r.aantal_kaartjes), 0) AS gereserveerd,
        100 - COALESCE(SUM(r.aantal_kaartjes), 0) AS vrij
    FROM films f
    LEFT JOIN reserveringen r ON f.id = r.film_id AND r.status != 'geannuleerd'
    GROUP BY f.id
");
$voorstellingen = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Zaalindeling/beschikbaarheid - MBO Cinemas</title>
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
            <h2 class="reserveren-title">Zaalindeling/beschikbaarheid</h2>
            <div class="reserveren-wrapper">
                <table class="reserveringen-tabel">
                    <tr>
                        <th>Film</th>
                        <th>Datum</th>
                        <th>Locatie</th>
                        <th>Zaal</th>
                        <th>Gereserveerd</th>
                        <th>Vrij</th>
                    </tr>
                    <?php foreach ($voorstellingen as $v): ?>
                    <tr>
                        <td><?= htmlspecialchars($v['titel']) ?></td>
                        <td><?= htmlspecialchars($v['datum']) ?></td>
                        <td><?= htmlspecialchars($v['locatie']) ?></td>
                        <td><?= htmlspecialchars($v['zaal']) ?></td>
                        <td><?= htmlspecialchars($v['gereserveerd']) ?></td>
                        <td><?= htmlspecialchars($v['vrij']) ?></td>
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
