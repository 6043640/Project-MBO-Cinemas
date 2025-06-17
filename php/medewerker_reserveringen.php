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
        r.id, 
        r.aantal_kaartjes, 
        r.status, 
        r.gereserveerd_op, 
        u.naam AS klant_naam, 
        u.email AS klant_email,
        f.titel AS film_titel,
        f.datum AS film_datum,
        f.locatie AS film_locatie,
        f.zaal AS film_zaal
    FROM reserveringen r
    JOIN users u ON r.klant_id = u.id
    JOIN films f ON r.film_id = f.id
");
$reserveringen = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Reserveringen beheren - MBO Cinemas</title>
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
            <h2 class="reserveren-title">Reserveringen beheren</h2>
            <div class="reserveren-wrapper">
                <table class="reserveringen-tabel">
                    <tr>
                        <th>Klant</th>
                        <th>E-mail</th>
                        <th>Film</th>
                        <th>Datum</th>
                        <th>Locatie</th>
                        <th>Zaal</th>
                        <th>Kaartjes</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                    <?php foreach ($reserveringen as $res): ?>
                    <tr>
                        <td><?= htmlspecialchars($res['klant_naam']) ?></td>
                        <td><?= htmlspecialchars($res['klant_email']) ?></td>
                        <td><?= htmlspecialchars($res['film_titel']) ?></td>
                        <td><?= htmlspecialchars($res['film_datum']) ?></td>
                        <td><?= htmlspecialchars($res['film_locatie']) ?></td>
                        <td><?= htmlspecialchars($res['film_zaal']) ?></td>
                        <td><?= htmlspecialchars($res['aantal_kaartjes']) ?></td>
                        <td><?= htmlspecialchars($res['status']) ?></td>
                        <td>
                            <a href="medewerker_reservering_update.php?id=<?= $res['id'] ?>" class="film-btn">Wijzigen</a>
                            <a href="medewerker_reservering_annuleer.php?id=<?= $res['id'] ?>" class="film-btn" onclick="return confirm('Weet je zeker dat je deze reservering wilt annuleren?')">Annuleren</a>
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
