<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker</title>
    <link rel="stylesheet" href="css/gebruiker.css">
</head>
<body>
    <img id="BG" src="img/Achtergrond.png">
    <img id="logo" src="img/logo.png" alt="logo">
    <p id="h1">Coptermail</p>
<?php
    session_start(); // Start de sessie

    if (!isset($_SESSION['user_id'])) {
        // Als de gebruiker niet is ingelogd, doorverwijzen naar de inlogpagina
        header("Location: inloggen.php");
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "kaasje";

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Verbinding mislukt: " . $conn->connect_error);
        }

        // Gebruik de sessie om de gegevens van de ingelogde gebruiker op te halen
        $user_id = $_SESSION['user_id'];

        // Selecteer de gebruikersnaam van de ingelogde gebruiker (zonder wachtwoord te tonen)
        $stmt = $conn->prepare("SELECT username FROM inloggen WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<table border='1'>
                <tr>
                    <th>Gebruikersnaam</th>
                    <th>Wachtwoord bijwerken</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['username']}</td>
                    <td><a href='update_password.php?id={$user_id}'>Wachtwoord bijwerken</a></td>
                </tr>";
        }

        echo "</table>";

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
?>
    <footer>
        <a href="home.php"><img class="footer_img" id="profiel" src="img/profiel.png"></a>
        <img class="footer_img" id="mandje" src="img/mandje.png">
        <a href="info.php"><img class="footer_img" id="info" src="img/info.png"></a>
        <a href="settings.php"><img class="footer_img" id="settings" src="img/settings.png"></a>
    </footer>
</body>
</html>