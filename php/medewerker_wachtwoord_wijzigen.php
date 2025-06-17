<?php
session_start();
if (!isset($_SESSION['klant_id']) || $_SESSION['rol'] !== 'medewerker') {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/database.php';
    $db = (new Database())->connect();
    $oud = $_POST['oud'] ?? '';
    $nieuw = $_POST['nieuw'] ?? '';
    $bevestig = $_POST['bevestig'] ?? '';
    $stmt = $db->prepare("SELECT wachtwoord FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['klant_id']]);
    $user = $stmt->fetch();
    if ($user && password_verify($oud, $user['wachtwoord']) && $nieuw === $bevestig) {
        $hash = password_hash($nieuw, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET wachtwoord = ? WHERE id = ?");
        $stmt->execute([$hash, $_SESSION['klant_id']]);
        $success = "Wachtwoord succesvol gewijzigd!";
    } else {
        $error = "Fout bij het wijzigen van het wachtwoord.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord wijzigen - MBO Cinemas</title>
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
            <h2 class="reserveren-title">Wachtwoord wijzigen</h2>
            <div class="reserveren-wrapper">
                <?php if (isset($error)): ?>
                    <div style="background:#ffeded;color:#b30000;padding:10px;margin-bottom:10px;border-radius:5px;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div style="background:#eaffea;color:#006600;padding:10px;margin-bottom:10px;border-radius:5px;">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>
                <form method="post" class="reserveren-form">
                    <label for="oud">Oud wachtwoord</label>
                    <input type="password" id="oud" name="oud" required>
                    <label for="nieuw">Nieuw wachtwoord</label>
                    <input type="password" id="nieuw" name="nieuw" required>
                    <label for="bevestig">Bevestig nieuw wachtwoord</label>
                    <input type="password" id="bevestig" name="bevestig" required>
                    <button type="submit" class="film-btn">Wijzig wachtwoord</button>
                </form>
                <a href="medewerker_account.php" class="film-btn">Terug naar account</a>
            </div>
        </section>
    </main>
    <footer class='voeter'>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
</body>
</html>
