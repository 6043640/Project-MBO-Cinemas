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
            <h2 class="reserveren-title">Reserveer je tickets</h2>
            <div class="reserveren-wrapper">
                <form class="reserveren-form">
                    <label for="naam">Naam</label>
                    <input type="text" id="naam" name="naam" placeholder="Naam" required>
                    
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                    
                    <label for="film">Film</label>
                    <select id="film" name="film" required>
                        <option value="">Kies een film</option>
                        <option value="badboys">Bad Boys</option>
                        <option value="fightclub">Fight Club</option>
                        <option value="godfather">Godfather</option>
                        <option value="pulpfiction">Pulp Fiction</option>
                    </select>
                    
                    <label for="datum">Datum</label>
                    <input type="date" id="datum" name="datum" required>
                    
                    <label for="tickets">Aantal tickets</label>
                    <input type="number" id="tickets" name="tickets" placeholder="Aantal tickets" min="1" max="10" required>
                    
                    <button type="submit" class="film-btn">Reserveer</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 MBO Cinemas</p>
    </footer>
    <script>
    document.querySelector('.reserveren-form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Bedankt voor je reservering!\nJe ontvangt binnenkort een bevestiging.');
        this.reset();
    });
    </script>
</body>
</html>