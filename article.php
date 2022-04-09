<html>
    <?php include "php/head.php"; ?>
    <body>
    <?php         
            include "php/header.php";            
            if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
                header("location: index.php");
            }
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
                        echo "<div class='cart-button'>In winkelwagen</div>";
                    ?>
                </div>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>