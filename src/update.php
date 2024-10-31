<!DOCTYPE html>
<html>
<head>
    <title>Update Gebruiker</title>
</head>
<body>
<h2>Update Gebruiker</h2>
<form method="POST" action="update.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label for="naam">Naam:</label>
    <input type="text" name="naam" value="<?php echo $naam; ?>"><br>
    <label for="achternaam">Achternaam:</label>
    <input type="text" name="achternaam" value="<?php echo $achternaam; ?>"><br>
    <label for="wachtwoord">Wachtwoord:</label>
    <input type="password" name="wachtwoord" value="<?php echo $wachtwoord; ?>"><br>
    <input type="submit" value="Update">
</form>
</body>
</html>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kaasje";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        updateGebruiker($conn, $_POST['id'], $_POST['naam'], $_POST['achternaam'], $_POST['wachtwoord']);
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($id, $naam, $achternaam, $wachtwoord);
        $stmt->fetch();
        $stmt->close();
    } else {
        throw new Exception("No user ID provided");
    }

    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

function updateGebruiker($conn, $id, $naam, $achternaam, $wachtwoord) {
    try {
        $stmt = $conn->prepare("UPDATE gebruikers SET naam=?, achternaam=?, wachtwoord=? WHERE id=?");
        $stmt->bind_param("sssi", $naam, $achternaam, $wachtwoord, $id);
        $stmt->execute();
        $stmt->close();

        header('Location: gebruikers.php');
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>