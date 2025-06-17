<?php
require_once '../config/database.php';
session_start();
$db = (new Database())->connect();

$zoekterm = isset($_GET['zoek']) ? trim($_GET['zoek']) : '';

try {
    
    $sql = "SELECT * FROM films";
    
    
    $params = [];
    if (!empty($zoekterm)) {
        $sql .= " WHERE 
            LOWER(titel) LIKE :zoek OR
            LOWER(genre) LIKE :zoek OR
            LOWER(locatie) LIKE :zoek OR
            LOWER(datum) LIKE :zoek";
        $params[':zoek'] = '%' . strtolower($zoekterm) . '%';
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Fout bij het ophalen van films: " . $e->getMessage());
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
</header>

<section class="blur-bg" aria-hidden="true"></section>
<main>
    <form method="GET" action="films.php" class="search-form">
        <input type="text" name="zoek" placeholder="Zoek films op titel, genre, locatie, datum" 
               value="<?= htmlspecialchars($zoekterm) ?>">
        <button type="submit">Zoeken</button>
    </form>

    <section class="films-section">
        <h2 class="reserveren-title">Nu in de bioscoop</h2>
        <?php if (count($films) > 0): ?>
        <ul class="film-lijst">
            <?php foreach ($films as $film): ?>
                <li class="film-card">
                    <img src="<?= htmlspecialchars($film['afbeelding']) ?>" 
                         alt="<?= htmlspecialchars($film['titel']) ?>" 
                         class="film-img">
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
