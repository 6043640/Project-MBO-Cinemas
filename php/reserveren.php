<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$conn = $database->connect();

try {
    $stmt = $conn->query("SELECT id, titel FROM films");
    $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Fout bij het ophalen van films: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBO Cinemas - Reserveer</title>
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
            <h2 class="reserveren-title">Reserveer je kaartjes</h2>
            <div class="reserveren-wrapper">
                <form class="reserveren-form" method="post" action="reserveren_verwerk.php">
                    <label for="naam">Naam</label>
                    <input type="text" id="naam" name="naam" placeholder="Naam" required>
                    
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                    
                    <label for="film_id">Film</label>
                    <select id="film_id" name="film_id" required>
                        <option value="">Kies een film</option>
                        <?php foreach ($films as $film): ?>
                            <option value="<?= $film['id'] ?>"><?= htmlspecialchars($film['titel']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label for="datum">Datum</label>
                    <input type="date" id="datum" name="datum" required>
                    
                    <label for="aantal_kaartjes">Aantal kaartjes</label>
                    <input type="number" id="aantal_kaartjes" name="aantal_kaartjes" placeholder="Aantal kaartjes" min="1" max="10" required>
                    
                    <button type="submit" class="film-btn">Reserveer</button>
                </form>
            </div>
        </section>
    </main>
    <footer class='voeter'>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
    <script src="reservering_localstorage.js"></script>
</body>
</html>
