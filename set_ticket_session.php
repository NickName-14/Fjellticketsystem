<?php
session_start();

if (isset($_GET['ticketid'])) {
    $_SESSION['ticketid'] = $_GET['ticketid'];
}

header("Location: ticket.php"); 
exit;
?>
