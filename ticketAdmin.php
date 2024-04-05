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
$sql_ticket = "SELECT Ticketid, TicketKategori, TicketStatus, Brukerid, TicketTilhørighet, Dato FROM Ticket WHERE Ticketid = '" . $_SESSION['ticketidAdmin'] . "' ";
$result_ticket = $link->query($sql_ticket);

if ($result_ticket->num_rows > 0) {
    echo "<h2>Ticket informasjon</h2>";
    echo "<table class='ticket-info-table'>";
    echo "<tr><th>Saksnummer</th><th>Kategori</th><th>Status</th><th>Bruker</th><th>Tekniker</th><th>Dato</th></tr>";
    while ($row = $result_ticket->fetch_assoc()) {
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
    echo "</table>";


    echo "<h2>Update Ticket Information</h2>";
    echo "<form action='update_ticket.php' method='post'>";
    echo "<table>";
    echo "<tr><td>Endre kategori:</td><td><input type='text' name='new_category'></td></tr>";
    echo "<tr><td>Endre status:</td><td><input type='text' name='new_status'></td></tr>";
    echo "<tr><td colspan='2'><input type='submit' value='Oppdater'></td></tr>";
    echo "</table>";
    echo "</form>";





    $sql_messages = "SELECT Avsender, Melingstekst FROM TicketMeldinger WHERE Ticketid =  '" . $_SESSION['ticketidAdmin']. "' ";
    $result_messages = $link->query($sql_messages);

    if ($result_messages->num_rows > 0) {
        echo "<br>";
        echo "<br>";
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
} else {
    echo "No ticket found.";
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