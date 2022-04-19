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
                        echo "<b>€".$article['article_price']."</b>";
                        echo "<input min-value='1' max-value='".$article['article_stock']."' type='number' value='1'>";
                        echo "<a class='cart-button' href='php/editCart.php?add=".$article['article_id']."'>In winkelwagen</a>";
                    ?>
                </div>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>