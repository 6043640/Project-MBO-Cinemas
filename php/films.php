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
            <a href="index.php" class="logo" aria-label="MBO Cinemas">
                <img src="../img/mbo-cinemas-logo.png" alt="MBO Cinemas logo" class="logo-img">
            </a>
            <nav class="nav-buttons" aria-label="Hoofdmenu">
                <a href="index.php">Home</a>
                <a href="reserveren.php">Reserveer</a>
                <a href="films.php">Films</a>
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
            <h2 class="reserveren-title">Nu in de bioscoop</h2>
            <ul class="film-lijst">
                <li class="film-card">
                    <img src="../img/badboys.jpg" alt="Bad Boys" class="film-img">
                    <h3>Bad Boys</h3>
                    <p>Actie, Komedie - Twee agenten nemen het op tegen de onderwereld van Miami.</p>
                    <a href="films.php" class="film-btn">Reserveer</a>
                </li>
                <li class="film-card">
                    <img src="../img/fightclub.jpg" alt="Fight Club" class="film-img">
                    <h3>Fight Club</h3>
                    <p>Drama, Thriller - Een man raakt verwikkeld in een geheime vechtclub.</p>
                    <a href="films.php" class="film-btn">Reserveer</a>
                </li>
                <li class="film-card">
                    <img src="../img/godfather.jpg" alt="Godfather" class="film-img">
                    <h3>The Godfather</h3>
                    <p>Misdaad, Drama - Het verhaal van een machtige maffiafamilie.</p>
                    <a href="films.php" class="film-btn">Reserveer</a>
                </li>
                <li class="film-card">
                    <img src="../img/pulpfiction.jpg" alt="Pulp Fiction" class="film-img">
                    <h3>Pulp Fiction</h3>
                    <p>Misdaad, Komedie - Meerdere verhaallijnen kruisen elkaar in Los Angeles.</p>
                    <a href="films.php" class="film-btn">Reserveer</a>
                </li>
            </ul>
        </section>
    </main>
</body>
</html>