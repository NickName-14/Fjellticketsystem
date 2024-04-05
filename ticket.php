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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fjellsupport</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class = "meny">
        <a href="index.php" class="menyknapp">Start</a>
        <a href="leggtil.php" class="menyknapp">Oppret sak</a>
        <a href="profil.php" class="menyknapp">Mine saker</a>
        <a href="login.php" class="menyknapp">Login</a>
        <a href="logut.php" class="menyknapp">Logut</a>
    </div>

    <div>

    <?php


$sql_ticket = "SELECT Ticketid, TicketKategori, TicketStatus, TicketTilhørighet  FROM Ticket WHERE Ticketid = '" . $_SESSION['ticketid'] . "' ";

$result_ticket = $link->query($sql_ticket);


if ($result_ticket->num_rows > 0) {
    echo "<h2>Ticket informasjon</h2>";
    echo "<table class='ticket-info-table'>";
    echo "<tr><th>Saksnummer</th><th>Kategori</th><th>Status</th><th>Tilhørighet</th></tr>";
    while ($row = $result_ticket->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Ticketid"] . "</td>";
        echo "<td>" . $row["TicketKategori"] . "</td>";
        echo "<td>" . $row["TicketStatus"] . "</td>";
        echo "<td>" . $row["TicketTilhørighet"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No ticket found.";
}


$sql_messages = "SELECT Avsender, Melingstekst FROM TicketMeldinger WHERE Ticketid =  '" . $_SESSION['ticketid']. "' ";

$result_messages = $link->query($sql_messages);


if ($result_messages->num_rows > 0) {
    echo "<h2>Ticket meldinger</h2>";
    while ($row = $result_messages->fetch_assoc()) {
        echo "<div class='meldingtekst'>";
        echo "<h3 id='Avsender'>" . $row["Avsender"] . "</h3>";
        echo "<p id='Meling'>" . $row["Melingstekst"] . "</p>";
        echo "</div>";
    }
    
} else {
    echo "No messages found for this ticket.";
}
?>
<form action="<?=($_SERVER["PHP_SELF"]);?>" method="post" class="form-group">

<div class ="form">
    <label for="text_input">Ny Melding: </label>
    <textarea name="text_input" id="text_input"></textarea>
    <br>
    <button type="submit">Send</button>

</div>

</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$avsender = $_SESSION['navn'];
$melingstekst = $_POST['text_input'];
$ticketid =  $_SESSION["ticketid"];

$sql = "INSERT INTO TicketMeldinger (Avsender, Melingstekst, Ticketid) VALUES (?, ?, ?)";
if ($stmt = $link->prepare($sql)) {
    $stmt->bind_param("sss", $param_avsender, $param_melingstekst, $param_ticketid);
    $param_avsender = $avsender;
    $param_melingstekst = $melingstekst;
    $param_ticketid = $ticketid;

    if ($stmt->execute()) {
        header("location: ticket.php");
        exit;
    } else {
        echo "Something went wrong. Please try again later.";
    }
} else {
    echo "Something went wrong. Please try again later.";
}
}

    ?>

    </div>
</body>
</html>