<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/homeslider.css">
</head>
<body>
    <img id="BG" src="img/Achtergrond.png">
    <img id="logo" src="img/logo.png" alt="logo">
    <p id="h1">Coptermail</p>

    <div class="container">
    <div class="tabs active" id="tab1">
        <div class="tab-content">
            <p>Hallo wij zijn Coptermail, wij bezorgen pakketjes aan consumten via drones. Hier op de app kun je allerlei dingen regelen voor Coptermail.</p>
        </div>
    </div>
    <div class="tabs" id="tab2">
        <div class="tab-content">
            <h1>welkom</h1>
            <img id="tab2" src="img/tab2.png">
            <p id="text2">Het bezorgen kan zelfs buiten je hoeft niet<br> thuis te zijn!</p>
        </div>
    </div>
    <div class="tabs" id="tab3">
        <div class="tab-content">
            <img id="tab3" src="img/tab3.png">
            <p id="text3">Er word goed voor je levering gezorgd!</p>
        </div>
    </div>
    <div class="tabs" id="tab4">
        <div class="tab-content">
            <img id="tab4" src="img/tab4.png">
            <p id="text4">Veel plezier op de Coptermail app!</p>
        </div>
    </div>

    <div class="navigation-buttons">
        <button id="prevBtn" onclick="prevTab()" disabled><<<</button>
        <button id="nextBtn" onclick="nextTab()">>>></button>
    </div>
</div>

    <footer>
        <a href="gebruiker.php"><img class="footer_img" id="profiel" src="img/profiel.png"></a>
        <img class="footer_img" id="mandje" src="img/mandje.png">
        <a href="info.php"><img class="footer_img" id="info" src="img/info.png"></a>
        <a href="settings.php"><img class="footer_img" id="settings" src="img/settings.png"></a>
    </footer>

<script>
    let currentTab = 1;

    function showTab(tabIndex) {
        // Verberg alle tabbladen
        const tabs = document.querySelectorAll('.tabs');
        tabs.forEach(tab => tab.classList.remove('active'));

        // Toon het huidige tabblad
        document.getElementById('tab' + tabIndex).classList.add('active');

        // Schakel de knoppen in/uit
        document.getElementById('prevBtn').disabled = (tabIndex === 1);
        document.getElementById('nextBtn').disabled = (tabIndex === tabs.length);
    }

    function nextTab() {
        if (currentTab < 4) {
            currentTab++;
            showTab(currentTab);
        }
    }

    function prevTab() {
        if (currentTab > 1) {
            currentTab--;
            showTab(currentTab);
        }
    }
</script>
</body>
</html>