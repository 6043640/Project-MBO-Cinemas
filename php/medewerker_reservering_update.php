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
    $stmt = $db->prepare("UPDATE reserveringen SET aantal_kaartjes = ?, status = ? WHERE id = ?");
    $stmt->execute([
        $_POST['aantal_kaartjes'],
        $_POST['status'],
        $id
    ]);
    header('Location: medewerker_reserveringen.php');
    exit;
}
$stmt = $db->prepare("
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
    WHERE r.id = ?
");
$stmt->execute([$id]);
$reservering = $stmt->fetch();
if (!$reservering) {
    header('Location: medewerker_reserveringen.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Reservering wijzigen - MBO Cinemas</title>
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
            <h2 class="reserveren-title">Reservering wijzigen</h2>
            <div class="reserveren-wrapper">
                <form class="reserveren-form" method="post">
                    <label for="aantal_kaartjes">Aantal kaartjes</label>
                    <input type="number" id="aantal_kaartjes" name="aantal_kaartjes" value="<?= htmlspecialchars($reservering['aantal_kaartjes']) ?>" required>
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="open" <?= $reservering['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                        <option value="bevestigd" <?= $reservering['status'] === 'bevestigd' ? 'selected' : '' ?>>Bevestigd</option>
                        <option value="geannuleerd" <?= $reservering['status'] === 'geannuleerd' ? 'selected' : '' ?>>Geannuleerd</option>
                    </select>
                    <button type="submit" class="film-btn">Opslaan</button>
                </form>
                <a href="medewerker_reserveringen.php" class="film-btn">Terug naar reserveringen</a>
            </div>
        </section>
    </main>
    <footer class='voeter'>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
</body>
</html>
