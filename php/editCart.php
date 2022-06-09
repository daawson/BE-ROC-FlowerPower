<?php
    require 'database.php';
    require 'session.php';

    if(isset($_POST['Submit'])){

        if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
            header("location: ../login.php");
        }else{
            $aid = $db->getArticle($_POST['a_id']);    
            $_SESSION['cart']->AddCartItem(new CartItem($aid['article_id'], $aid['article_name'], $_POST['a_quantity'], $aid['article_price']));
        }
    }

    if(isset($_GET['remove'])){  
        $_SESSION['cart']->RemoveCartItem($_GET['remove']);
    }