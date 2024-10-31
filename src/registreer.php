<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="css/registreer.css">
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
    <form action="registreer.php" method="post">
        <input type="text" class="inputs" name="username" placeholder="Gebruikersnaam" required><br>
        <input type="password" class="inputs" name="password" placeholder="Wachtwoord" required><br>
        <input type="password" class="inputs" name="repeat_password" placeholder="Herhaal Wachtwoord" required><br>
        <input type="submit" id="submit" name="registreer" value="Registreer">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Haal gebruikersinvoer op
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];

        // Controleer of de wachtwoorden overeenkomen
        if ($password !== $repeat_password) {
            echo "<p style='color: red;'>De wachtwoorden komen niet overeen.</p>";
            exit();
        }

        try {
            // Verbinding maken met de database
            $host = "localhost";
            $user = "root";
            $pass = "root";
            $database = "kaasje";
            $conn = new mysqli($host, $user, $pass, $database);

            // Controleer verbinding
            if ($conn->connect_error) {
                throw new Exception("Verbinding mislukt: " . $conn->connect_error);
            }

            // Controleer of de gebruikersnaam al bestaat
            $checkQuery = "SELECT COUNT(*) FROM inloggen WHERE username = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("s", $username);
            $checkStmt->execute();
            $checkStmt->bind_result($userCount);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($userCount > 0) {
                throw new Exception("Deze gebruikersnaam is al in gebruik. Kies een andere.");
            }

            // Voorbereid SQL-query (zonder hashing)
            $query = "INSERT INTO inloggen (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $username, $password);

            // Voer de query uit
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Registratie succesvol!</p>";
                header("Location: inloggen.php"); // Stuur door naar inlogpagina na succes
                exit();
            } else {
                throw new Exception("Er is iets misgegaan tijdens de registratie.");
            }

        } catch (Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        } finally {
            // Sluit de verbinding en de statement
            if (isset($stmt)) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
?>
</body>
</html>