<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Reservering.php';

if (!isset($_SESSION['klant_id'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$conn = $database->connect();
$reserveringObj = new Reservering($conn);

$klant_id = $_SESSION['klant_id'];
$reserveringen = $reserveringObj->getByKlant($klant_id);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Mijn Reserveringen - MBO Cinemas</title>
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
                <a href="reserveren.php">Reserveer</a>
                <a href="films.php">Films</a>
                <?php if (isset($_SESSION['klant_id'])): ?>
                    <a href="mijn_reserveringen.php">Mijn Reserveringen</a>
                <?php endif; ?>
            </nav>
            <a href="login.php" class="login-icon" title="Inloggen">
                <img src="../img/LoginLogo.png" alt="Login" />
            </a>
        </section>
        <section class="banner-img"></section>
    </header>
    <section class="blur-bg" aria-hidden="true"></section>
    <main>
        <section class="films-section">
            <h2 class="reserveren-title">Mijn Reserveringen</h2>
            <div class="reserveren-wrapper">
                <?php if (empty($reserveringen)): ?>
                    <p>Je hebt geen actieve reserveringen.</p>
                <?php else: ?>
                    <table class="reserveringen-tabel">
                        <thead>
                            <tr>
                                <th>Film</th>
                                <th>Datum</th>
                                <th>Aantal kaartjes</th>
                                <th>Status</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reserveringen as $res): ?>
                                <?php
                                    $stmt = $conn->prepare("SELECT titel FROM films WHERE id = ?");
                                    $stmt->execute([$res['film_id']]);
                                    $film = $stmt->fetch();
                                    $film_titel = $film ? htmlspecialchars($film['titel']) : "Onbekende film";
                                ?>
                                <tr>
                                    <td><?= $film_titel ?></td>
                                    <td><?= htmlspecialchars($res['datum']) ?></td>
                                    <td>
                                        <form method="post" action="reservering_update.php">
                                            <input type="hidden" name="res_id" value="<?= $res['id'] ?>">
                                            <input type="number" name="nieuw_aantal" value="<?= $res['aantal_kaartjes'] ?>" min="1" max="10" required>
                                            <button type="submit" class="film-btn">Wijzig</button>
                                        </form>
                                    </td>
                                    <td><?= htmlspecialchars($res['status']) ?></td>
                                    <td>
                                        <form method="post" action="reservering_annuleer.php" onsubmit="return confirm('Weet je zeker dat je wilt annuleren?');">
                                            <input type="hidden" name="res_id" value="<?= $res['id'] ?>">
                                            <button type="submit" class="film-btn">Annuleer</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <footer class="voeter">
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
</body>
</html>
