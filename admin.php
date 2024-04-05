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
<div class = "meny">
        <a href="index.php" class="menyaktiv">Start</a>
        <a href="leggtil.php" class="menyknapp">Oppret sak</a>
        <a href="profil.php" class="menyknapp">Mine saker</a>
        <a href="login.php" class="menyknapp">Login</a>
        <a href="logut.php" class="menyknapp">Logut</a>
    </div>
<body>
    <br>
    <table class = "TicketPW">
        <tr>
            <th>Saksnummer</td>
            <th>Kategori</td>
            <th>Status</td>
            <th>Kunde</td>
            <th>Tekniker</td>
            <th>Dato</th>
        </tr>
        <?php
        $sql = "SELECT Ticketid, TicketKategori, TicketStatus, Brukerid, TicketTilhørighet, Dato  FROM Ticket";


        $result = $link->query($sql);


        if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            
            $navn_query = "SELECT navn FROM Bruker WHERE Brukerid = '". $row["Brukerid"] . "'";
            $navn_result = $link->query($navn_query);
            $navn = ($navn_result->num_rows > 0) ? $navn_result->fetch_assoc()["navn"] : "Unknown";
    
            $tilhørighet_query = "SELECT Navn FROM Ansatt WHERE Ansattid = '". $row["TicketTilhørighet"] . "'";
            $tilhørighet_result = $link->query($tilhørighet_query);
            $tilhørighet = ($tilhørighet_result->num_rows > 0) ? $tilhørighet_result->fetch_assoc()["Navn"] : "Unknown";
    
            echo "<tr>";
            echo "<td>" . $row["Ticketid"] . "</td>";
            echo "<td>" . $row["TicketKategori"] . "</td>";
            echo "<td>" . $row["TicketStatus"] . "</td>";
            echo "<td>" . $navn . "</td>";
            echo "<td>" . $tilhørighet . "</td>";
            echo "<td>" . $row["Dato"] . "</td>";
            echo "</tr>";
        }
        } else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>