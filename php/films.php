<?php
require_once '../config/database.php';
require_once '../classes/Film.php';

$db = new Database();
$pdo = $db->connect();

$filmModel = new Film($pdo);
$zoekterm = $_GET['zoek'] ?? '';
$films = $filmModel->zoekFilms($zoekterm);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>MBO Cinemas - Films</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <section class="header-bar">
        <a href="../index.php" class="logo" aria-label="MBO Cinemas">
            <img src="../img/mbo-cinemas-logo.png" alt="MBO Cinemas logo" class="logo-img">
        </a>
        <nav class="nav-buttons" aria-label="Hoofdmenu">
            <a href="../index.php">Home</a>
            <a href="../reserveren.php">Reserveer</a>
            <a href="films.php">Films</a>
        </nav>
        <a href="../login.php" class="login-icon" title="Inloggen">
            <img src="../img/LoginLogo.png" alt="Login" />
        </a>
    </section>
    <section class="banner-img"></section>
</header>

<section class="blur-bg" aria-hidden="true"></section>
<main>
    <form method="GET" action="films.php" class="search-form">
        <input type="text" name="zoek" placeholder="Zoek films op titel, genre, locatie, datum" value="<?= htmlspecialchars($zoekterm) ?>" />
        <button type="submit">Zoeken</button>
    </form>

    <section class="films-section">
        <h2 class="reserveren-title">Nu in de bioscoop</h2>
        <?php if (count($films) > 0): ?>
        <ul class="film-lijst">
            <?php foreach ($films as $film): ?>
                <li class="film-card">
                    <?php
                        $imgFile = '../img/' . htmlspecialchars($film['titel']) . '.jpg';
                        if (!file_exists($imgFile)) {
                            $imgFile = '../img/placeholder.png';
                        }
                    ?>
                    <img src="<?= $imgFile ?>" alt="<?= htmlspecialchars($film['titel']) ?>" class="film-img">
                    <h3><?= htmlspecialchars($film['titel']) ?></h3>
                    <p><?= htmlspecialchars($film['genre']) ?></p>
                    <p><strong>Locatie:</strong> <?= htmlspecialchars($film['locatie']) ?></p>
                    <p><strong>Datum:</strong> <?= htmlspecialchars($film['datum']) ?></p>
                    <a href="../reserveren.php" class="film-btn">Reserveer</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
            <p style="color:white;">Geen films gevonden die aan je zoekopdracht voldoen.</p>
        <?php endif; ?>
    </section>

</main>
<footer class="voeter">
    <p>&copy; 2025 MBO Cinemas</p>
</footer>
</body>
</html>
