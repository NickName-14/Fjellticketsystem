<?php
session_start();

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_category = isset($_POST['new_category']) ? mysqli_real_escape_string($link, $_POST['new_category']) : '';
    $new_status = isset($_POST['new_status']) ? mysqli_real_escape_string($link, $_POST['new_status']) : '';
    

    if (!isset($_SESSION['ticketidAdmin'])) {
        echo "Ticket ID not set.";
        exit;
    }


    $sql_update = "UPDATE Ticket SET TicketKategori = '$new_category', TicketStatus = '$new_status' WHERE Ticketid = '" . $_SESSION['ticketidAdmin'] . "'";
    if (mysqli_query($link, $sql_update)) {
        header("location: ticketAdmin.php");
    } else {
        echo "Error updating ticket information: " . mysqli_error($link);
    }
} else {
    echo "Invalid request.";
}
?>
