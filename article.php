<html>
    <?php include "php/head.php"; ?>
    <body>
    <?php         
            include "php/header.php";            
            // if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
            //     header("location: index.php");
            // }
            $article = $db->getArticle($_GET['id']);
        ?>

        <div id="main-container">
            <div id="article-container">
                <div class="block-50">
                    <?php                 
                        echo "<img src='".$article['article_photoDir']."'>";
                    ?>
                </div>
                <div class="block-50">
                    <?php
                        echo "<h1>".$article['article_name']."</h1>";
                        echo "<p>".$article['article_desc']."</p>";                        
                        echo "<b>Voorraad: ".$article['article_stock']."</b>";
                        echo "<b>€".$article['article_price']."</b>";
                        if($_SESSION['cart']->HasItemInCart($article['article_id'])) {                            
                            echo "<a class='cart-button unavailable' href='cart.php'>Al in winkelwagen</a>";
                        }
                        else if($article['article_stock'] != 0){
                            echo "<form method='POST' action='php/editCart.php' class='cart-box'><br>";
                            echo "Aantal<input min='1' name='a_quantity' id='a_quantity' max='".$article['article_stock']."' type='number' value='1'>";
                            echo "<input type='hidden' name='a_id' id='a_id' value='".$article['article_id']."'>";
                            echo "<input type='submit' class='cart-button' name='Submit' value='in Winkelwagen'>";
                            echo "</form>";
                        }
                        else{
                            echo "<div class='cart-button unavailable'>Niet beschikbaar</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>