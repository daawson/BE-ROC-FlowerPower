<?php 
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['logged_in'] = false;    
    $_SESSION['cart'] = null;
    header("location: ../index.php");
?>