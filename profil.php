<?php
session_start();

require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
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
        <a href="profil.php" class="menyaktiv">Mine saker</a>
        <a href="login.php" class="menyknapp">Login</a>
        <a href="logut.php" class="menyknapp">Logut</a>
    </div>

    <h1 class="velkommen">Velkommen
        <?php echo ($_SESSION["navn"]); ?>
     her der dine saker</h1>
<div id = "ticketpw">
<table class="TicketPW">
    <tr>
        <td>Saksnummer</td>
        <td>Kategori</td>
        <td>Status</td>
        <td>Tekniker</td>
    </tr>
    <?php
    $sql_ticket = "SELECT Ticketid, TicketKategori, TicketStatus, TicketTilhørighet  FROM Ticket WHERE Brukerid = '" . $_SESSION["id"] . "' ";
    $result_ticket = $link->query($sql_ticket);
    if ($result_ticket->num_rows > 0) {
        while ($row = $result_ticket->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a class='ticketlink' href='set_ticket_session.php?ticketid=" . $row["Ticketid"] . "'>" . $row["Ticketid"] . "</a></td>";
            echo "<td>" . $row["TicketKategori"] . "</td>";
            echo "<td>" . $row["TicketStatus"] . "</td>";
            echo "<td>" . $row["TicketTilhørighet"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No tickets found</td></tr>";
    }
    ?>
</table>

</div>
</body>
</html>