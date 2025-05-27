<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBO Cinemas - Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <section class="header-bar">
            <a href="index.html" class="logo" aria-label="MBO Cinemas">
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
            <h2 class="reserveren-title">Inloggen</h2>
            <div class="reserveren-wrapper">
                <form class="reserveren-form">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                    
                    <label for="wachtwoord">Wachtwoord</label>
                    <input type="password" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord" required>
                    
                    <button type="submit" class="film-btn">Inloggen</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
</body>
</html>