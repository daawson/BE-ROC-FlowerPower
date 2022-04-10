<html>
    <?php include "php/head.php"; ?>
    <body>
    <?php         
            include "php/header.php";            
            if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
                header("location: index.php");
            }
        ?>

        <div id="main-container">
            <div id="article-container">
                <div class="block-50">
                    <?php $db->getAndEditArticleData($_GET['id']); ?>
                </div>                
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>