<?php
session_start();


$_SESSION = array();


session_destroy();


setcookie("bruker", "", time() - 3600 * 24 * 30, "/");
setcookie("pass", "", time() - 3600 * 24 * 30, "/");


header("location: index.php");
exit();
?>
