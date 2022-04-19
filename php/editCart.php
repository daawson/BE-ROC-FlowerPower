<?php
    require 'database.php"';
    require 'session.php';
    
    if(!isset($_SESSION["logged_in"])){
        header("location: login.php");
    }

    if(isset($_GET['add'])){
        $aid = $db->getArticle($_GET['add']);    
        $_SESSION['cart']->AddCartItem(new CartItem($aid['article_id'], $aid['article_name'], 1, $aid['article_price']));
    }

    if(isset($_GET['remove'])){  
        $_SESSION['cart']->RemoveCartItem($_GET['remove']);
    }