<?php
    require 'database.php"';
    require 'session.php';


    if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
        header("location: ../login.php");
    }
    else{
        if(isset($_GET['id']) && isset($_GET['type'])){
            $data = array($_GET['type'], $_GET['id']);
            $db->updateOrder($data);
        }
        
        else{
            header("location: ../userpage.php");
        }
    }