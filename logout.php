<?php 
    session_start();
    session_unset(); // Καθαρισμός των μεταβλητών 
    session_destroy(); // Καταστροφή του session
    header('Location: index.php'); 
    die;
?>