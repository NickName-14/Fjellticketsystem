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
        <a href="index.php" class="menyknapp">Start</a>
        <a href="leggtil.php" class="menyaktiv">Oppret sak</a>
        <a href="profil.php" class="menyknapp">Mine saker</a>
        <a href="login.php" class="menyknapp">Login</a>
        <a href="logut.php" class="menyknapp">Logut</a>
    </div>

    <h1>Oppret sak</h1>

    <form action="<?=($_SERVER["PHP_SELF"]);?>" method="post" class="form-group">

    <div class ="form">
    <label for="select_option">Velg kategori: </label>
        <select name="select_option" id="kategori">
            <option value="E-post">E-post</option>
            <option value="Login">Login</option>
            <option value="Betaling">Betaling</option>
            <option value="Annet">Annet</option>
        </select>
        <br>
        <label for="text_input">Beskrivelse: </label>
        <textarea name="text_input" id="text_input"></textarea>
        <br>
        <button type="submit">Oppret sak</button>

    </div>

    </form>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    
    $sql = "SELECT COUNT(*) AS totalRows FROM Ansatt";
    
    $result = $link->query($sql);
    
    if ($result) {
    
    $row = $result->fetch_assoc();
    }
    
    $max = $row['totalRows'];
   
    
    $randomNumber = rand(1, $max);
    
    $tilhørighet = $randomNumber;

    $brukerid = $_SESSION['id'];
    $kategori = $_POST['select_option'];
    $status = "Ny";
   

    $sql = "INSERT INTO Ticket (TicketKategori, TicketStatus, Brukerid, TicketTilhørighet, Dato) VALUES (?, ?, ?, ?, NOW())";
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("ssss", $param_kategori, $param_status, $param_brukerid, $param_tilhørighet);
        $param_kategori = $kategori;
        $param_status = $status;
        $param_brukerid = $brukerid;
        $param_tilhørighet = $tilhørighet;

        if ($stmt->execute()) {
            $last_insert_id = $stmt->insert_id;
            $stmt->close();

            $avsender = $_SESSION['navn'];
            $melingstekst = $_POST['text_input'];
            
            $sql = "INSERT INTO TicketMeldinger (Avsender, Melingstekst, Ticketid) VALUES (?, ?, ?)";
            if ($stmt = $link->prepare($sql)) {
                $stmt->bind_param("sss", $param_avsender, $param_melingstekst, $param_ticketid);
                $param_avsender = $avsender;
                $param_melingstekst = $melingstekst;
                $param_ticketid = $last_insert_id;

                if ($stmt->execute()) {
                    //header("location: profil.php");
                    exit;
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
}

?>