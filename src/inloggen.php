<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="css/inloggen.css">
</head>
<body>
    <img id="BG" src="img/Achtergrond.png">
    <nav>
        <div id="inloggen"><br><a class="hover" href="inloggen.php">Inloggen</a></div>
        <div id="maken"><br><a class="hover" href="registreer.php">Account maken</a></div>
    </nav>
    <br><br><br><br><br>
    <img id="logo" src="img/logo.png" alt="logo">
    <p id="h1">Coptermail</p>

    <!-- Formulier voor inloggen -->
    <form id="form" action="inloggen.php" method="post">
        <input class="inputs" type="text" name="username" placeholder="Gebruikersnaam" required><br>
        <input class="inputs" type="password" name="password" placeholder="Wachtwoord" required><br>
        <input id="submit" class="hover" type="submit" name="login" value="Verder">
    </form>

    <a id="vergeten" class="hover" href="wachtwoord.php">Wachtwoord vergeten?</a><br>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start(); // Start de sessie

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $host = "localhost";
        $user = "root";
        $pass = "root";
        $database = "kaasje";
        $conn = new mysqli($host, $user, $pass, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Verkrijg en ontsmet de invoer van de gebruiker
        $username = $conn->real_escape_string($_POST['username']);
        $password = $_POST['password'];  // Geen ontsmetting van wachtwoorden nodig voor directe vergelijking

        // Gebruik prepared statement voor beveiliging tegen SQL-injecties
        $stmt = $conn->prepare("SELECT id, password FROM inloggen WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Controleer of de gebruiker bestaat
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $stored_password);
            $stmt->fetch();

            // Controleer of het wachtwoord klopt (directe vergelijking zonder hashing)
            if ($password === $stored_password) {
                // Sla gebruikersgegevens op in sessie
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;

                // Doorsturen naar homepagina na succesvolle login
                header("Location: home.php");
                exit();
            } else {
                echo "<p style='color:red;'>Ongeldige gebruikersnaam of wachtwoord.</p>";
            }
        } else {
            echo "<p style='color:red;'>Ongeldige gebruikersnaam of wachtwoord.</p>";
        }

        $stmt->close();
        $conn->close();
    }
?>
</body>
</html>