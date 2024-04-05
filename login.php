<?php
session_start();

require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true) {
    header("location: profil.php");
    exit;
}

$e_post_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["e-post"]) && isset($_GET["passord"])) {
        $e_post = $_GET["e-post"];
        $password = $_GET["passord"];
        
        if (empty($e_post)) {
            $e_post_err = "E-post er nødvendig.";
        }

        if (empty($password)) {
            $password_err = "Passord er nødvendig.";
        }

        if (empty($e_post_err) && empty($password_err)) {
            $sql = "SELECT Brukerid, Navn, `E-post`, Passord FROM Bruker WHERE `E-post` = ?";

            if ($stmt = $link->prepare($sql)) {
                $stmt->bind_param("s", $e_post);
                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($id, $navn, $db_e_post, $db_password);
                        if ($stmt->fetch()) {
                            if ($password === $db_password) {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["navn"] = $navn;
                                $_SESSION["e-post"]  = $db_e_post;
                                header("location: index.php");
                                exit();
                            } else {
                                $password_err = "Passordet er feil.";
                            }
                        }
                    } else {
                        $e_post_err = "Fant ingen Brukere med denne e-post addressen.";
                    }
                } else {
                    echo "Noe gikk galt. Vennligst prøv igjen senere.";
                }
                $stmt->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fjellsupport</title>
    <link rel="icon" type="image/x-icon" href="assets/jpg/linje5.jpg">
</head>
<body>
    <form action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET" class="form-group">
        <div class="containerlogin">
            <label for="uname"><b>E-post</b></label>
            <input type="text" placeholder="Skriv inn E-post" name="e-post">
            <label for="psw"><b>Passord</b></label>
            <input type="password" placeholder="Skriv inn Passord" name="passord">
            <button type="submit" id="loginbtn">Login</button>
            <label>
                <input type="checkbox" checked="checked" name="remember_me"> Husk meg
            </label>
        </div>
        <div class="wrapperlog" style="background-color:#f1f1f1">
            <a class="psw" href="registrering.php">Registrering</a>
        </div>
    </form>
    <?php
    echo "<div class='error'>";
    echo $password_err;
    echo $e_post_err;
    echo "</div>";
    ?>
</body>
</html>
