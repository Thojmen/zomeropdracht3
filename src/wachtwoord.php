<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gegevens uit database</title>
    <link rel="stylesheet" href="css/wachtwoord.css">
</head>
<body>
<img id="BG" src="img/Achtergrond.png">
<img id="logo" src="img/logo.png" alt="logo">
<p id="h1">Coptermail</p>
<p id="gegevens">Hier zijn alle inlog gegevens ;)</p>
    <table>
        <thead>
            <tr>
                <th>Gebruikersnaam</th>
                <th>Wachtwoord</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $host = "localhost";
            $user = "root";
            $pass = "root";
            $database = "kaasje";
            $conn = new mysqli($host, $user, $pass, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT * FROM inloggen";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Geen gegevens gevonden</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    <a class="hover" href="inloggen.php">Terug naar inloggen.</a></div>
</body>
</html>