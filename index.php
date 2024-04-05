<?php
session_start();

require_once "config.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fjellsupport</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class = "meny">
        <a href="index.php" class="menyaktiv">Start</a>
        <a href="leggtil.php" class="menyknapp">Oppret sak</a>
        <a href="profil.php" class="menyknapp">Mine saker</a>
        <a href="login.php" class="menyknapp">Login</a>
        <a href="logut.php" class="menyknapp">Logut</a>
    </div>
</body>
</html>