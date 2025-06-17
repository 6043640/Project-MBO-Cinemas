<?php
$films = [
    [
        'titel' => 'Bad Boys',
        'genre' => 'Actie, Komedie',
        'locatie' => 'Alphen aan den Rijn',
        'datum' => '2025-06-20',
        'afbeelding' => '../img/bad boys.jpg'
    ],
    [
        'titel' => 'Fight Club',
        'genre' => 'Drama, Thriller',
        'locatie' => 'Alphen aan den Rijn',
        'datum' => '2025-06-21',
        'afbeelding' => '../img/fight club.jpg'
    ],
    [
        'titel' => 'Godfather',
        'genre' => 'Misdaad, Drama',
        'locatie' => 'Alphen aan den Rijn',
        'datum' => '2025-06-22',
        'afbeelding' => '../img/godfather.jpg'
    ],
    [
        'titel' => 'Pulp Fiction',
        'genre' => 'Misdaad, Komedie',
        'locatie' => 'Alphen aan den Rijn',
        'datum' => '2025-06-23',
        'afbeelding' => '../img/pulp fiction.jpg'
    ]
];

// Zoekterm ophalen en normaliseren
$zoekterm = isset($_GET['zoek']) ? strtolower(trim($_GET['zoek'])) : '';

// Filteren op zoekterm (titel, genre, locatie, datum) - alleen tonen wat overeenkomt
$gefilterdeFilms = [];
if ($zoekterm !== '') {
    foreach ($films as $film) {
        if (
            strpos(strtolower($film['titel']), $zoekterm) !== false ||
            strpos(strtolower($film['genre']), $zoekterm) !== false ||
            strpos(strtolower($film['locatie']), $zoekterm) !== false ||
            strpos(strtolower($film['datum']), $zoekterm) !== false
        ) {
            $gefilterdeFilms[] = $film;
        }
    }
} else {
    $gefilterdeFilms = $films;
}
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
            <a href="index.php">Home</a>
            <a href="reserveren.php">Reserveer</a>
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
        <input type="text" name="zoek" placeholder="Zoek films op titel, genre, locatie, datum" value="<?= htmlspecialchars(isset($_GET['zoek']) ? $_GET['zoek'] : '') ?>" />
        <button type="submit">Zoeken</button>
    </form>

    <section class="films-section">
        <h2 class="reserveren-title">Nu in de bioscoop</h2>
        <?php if (count($gefilterdeFilms) > 0): ?>
        <ul class="film-lijst">
            <?php foreach ($gefilterdeFilms as $film): ?>
                <li class="film-card">
                    <img src="<?= htmlspecialchars($film['afbeelding']) ?>" alt="<?= htmlspecialchars($film['titel']) ?>" class="film-img">
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