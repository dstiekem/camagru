<?php
    session_start();
    session_destroy();
    header('Location: ../mvc2/login.php');
?>
