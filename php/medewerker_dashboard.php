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
    <title>Medewerker Dashboard - MBO Cinemas</title>
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
            <h2 class="reserveren-title">Medewerker Dashboard</h2>
            <div class="reserveren-wrapper">
                <div style="display: flex; flex-direction: column; gap: 20px; max-width: 600px; width: 100%;">
                    <a href="medewerker_films.php" class="film-btn">Films beheren</a>
                    <a href="medewerker_reserveringen.php" class="film-btn">Reserveringen beheren</a>
                    <a href="medewerker_zaalindeling.php" class="film-btn">Zaalindeling/beschikbaarheid</a>
                    <a href="medewerker_account.php" class="film-btn">Mijn account</a>
                </div>
            </div>
        </section>
    </main>
    <footer class='voeter'>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
</body>
</html>
