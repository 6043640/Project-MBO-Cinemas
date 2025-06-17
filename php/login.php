<?php
require_once '../config/database.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$db = (new Database())->connect();

$error = '';
$success = '';

if (isset($_POST['register'])) {
    $username = trim($_POST['reg_username']);
    $email = trim($_POST['reg_email']);
    $password = $_POST['reg_password'];

    if ($username && $email && $password) {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email OR naam = :naam");
        $stmt->execute([':email' => $email, ':naam' => $username]);
        if ($stmt->fetch()) {
            $error = "Gebruiker met deze e-mail of gebruikersnaam bestaat al.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (naam, email, wachtwoord, rol) VALUES (:naam, :email, :wachtwoord, 'klant')");
            if ($stmt->execute([':naam' => $username, ':email' => $email, ':wachtwoord' => $hash])) {
                $success = "Registratie gelukt! Je kunt nu inloggen.";
            } else {
                $error = "Registratie mislukt. Probeer het opnieuw.";
            }
        }
    } else {
        $error = "Vul alle velden in voor registratie.";
    }
}

if (isset($_POST['login'])) {
    $email = trim($_POST['login_email']);
    $password = $_POST['login_password'];

    if ($email && $password) {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['wachtwoord'])) {
            $_SESSION['klant_id'] = $user['id'];
            $_SESSION['username'] = $user['naam'];
            $_SESSION['rol'] = $user['rol'];
            if ($user['rol'] === 'medewerker') {
                header('Location: medewerker_dashboard.php');
                exit;
            } else {
                header('Location: index.php');
                exit;
            }
        } else {
            $error = "Ongeldige inloggegevens.";
        }
    } else {
        $error = "Vul alle velden in om in te loggen.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBO Cinemas - Login & Registratie</title>
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
            <h2 class="reserveren-title">Inloggen or Registreren</h2>
            <div class="reserveren-wrapper">
                <div style="width:100%;">
                    <?php if ($error): ?>
                        <div style="background:#ffeded;color:#b30000;padding:10px;margin-bottom:10px;border-radius:5px;">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div style="background:#eaffea;color:#006600;padding:10px;margin-bottom:10px;border-radius:5px;">
                            <?= $success ?>
                        </div>
                    <?php endif; ?>
                    <div style="display:flex;gap:40px;flex-wrap:wrap;">
                        
                        <form class="reserveren-form" method="post" style="min-width:250px;">
                            <h3 style="color:#c88336;">Inloggen</h3>
                            <label for="login_email">E-mail</label>
                            <input type="email" id="login_email" name="login_email" placeholder="E-mail" required>
                            <label for="login_password">Wachtwoord</label>
                            <input type="password" id="login_password" name="login_password" placeholder="Wachtwoord" required>
                            <button type="submit" name="login" class="film-btn">Inloggen</button>
                        </form>

                        <form class="reserveren-form" method="post" style="min-width:250px;">
                            <h3 style="color:#c88336;">Registreren</h3>
                            <label for="reg_username">Gebruikersnaam</label>
                            <input type="text" id="reg_username" name="reg_username" placeholder="Gebruikersnaam" required>
                            <label for="reg_email">E-mail</label>
                            <input type="email" id="reg_email" name="reg_email" placeholder="E-mail" required>
                            <label for="reg_password">Wachtwoord</label>
                            <input type="password" id="reg_password" name="reg_password" placeholder="Wachtwoord" required>
                            <button type="submit" name="register" class="film-btn">Registreren</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class='voeter'>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
    <?php if ($success): ?>
    <script>
        alert("<?= addslashes($success) ?>");
    </script>
    <?php endif; ?>
    <?php if ($error): ?>
    <script>
        alert("<?= addslashes($error) ?>");
    </script>
    <?php endif; ?>
</body>
</html>