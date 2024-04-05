<?php
session_start();

if (isset($_GET['ticketid'])) {
    $_SESSION['ticketidAdmin'] = $_GET['ticketid'];
}

header("Location: ticketAdmin.php"); 
exit;
?>