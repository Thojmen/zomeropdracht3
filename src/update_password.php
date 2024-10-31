<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: inloggen.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kaasje";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Haal de huidige gebruiker op
        $user_id = $_SESSION['user_id'];

        // Haal het huidige wachtwoord op uit de database
        $stmt = $conn->prepare("SELECT password FROM inloggen WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Verifieer het huidige wachtwoord
        if (password_verify($current_password, $hashed_password)) {
            if ($new_password === $confirm_password) {
                // Hash het nieuwe wachtwoord
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Werk het wachtwoord bij in de database
                $stmt = $conn->prepare("UPDATE inloggen SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $new_hashed_password, $user_id);
                $stmt->execute();
                $stmt->close();

                echo "Wachtwoord succesvol bijgewerkt!";
            } else {
                echo "De wachtwoorden komen niet overeen!";
            }
        } else {
            echo "Het huidige wachtwoord is onjuist!";
        }

        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord bijwerken</title>
    <link rel="stylesheet" href="css/update_wachtwoord.css">
</head>
<body>
<img id="BG" src="img/Achtergrond.png">
<a id="terug" class="hover" href="gebruiker.php">terug</a>
<img id="logo" src="img/logo.png" alt="logo">
<p id="h1">Coptermail</p>
    <h2 id="h2">Wachtwoord bijwerken</h2>
    <form action="update_password.php" method="post">
        <input type="password" class="inputs" name="current_password" placeholder="Huidig wachtwoord" required><br>
        <input type="password" class="inputs" name="new_password" placeholder="Nieuw wachtwoord" required><br>
        <input type="password" class="inputs" name="confirm_password" placeholder="Bevestig nieuw wachtwoord" required><br>
        <input type="submit" id="submit" value="Wachtwoord bijwerken">
    </form>
</body>
</html>