<?php
session_start();
if (!isset($_SESSION['klant_id']) || $_SESSION['rol'] !== 'medewerker') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Mijn Account - MBO Cinemas</title>
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
            <h2 class="reserveren-title">Mijn Account</h2>
            <div class="reserveren-wrapper">
                <div style="display: flex; flex-direction: column; gap: 20px; max-width: 600px; width: 100%;">
                    <p>Naam: <?= htmlspecialchars($_SESSION['username']) ?></p>
                    <p>E-mail: <?= htmlspecialchars($_SESSION['email'] ?? '') ?></p>
                    <p>Rol: <?= htmlspecialchars($_SESSION['rol']) ?></p>
                    <a href="medewerker_wachtwoord_wijzigen.php" class="film-btn">Wachtwoord wijzigen</a>
                    <a href="medewerker_dashboard.php" class="film-btn">Terug naar dashboard</a>
                </div>
            </div>
        </section>
    </main>
    <footer class='voeter'>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
</body>
</html>
