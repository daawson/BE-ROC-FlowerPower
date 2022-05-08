<html>
    <?php include "php/head.php"; ?>
    <body>
    <?php         
            include "php/header.php";            
            if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
                header("location: index.php");
            }
            
            if($_SESSION['user_level'] == "administrator") $admin = 1;
        ?>

        <div id="main-container">
            <div id="article-container">
                <div class="block-full flex-to-left">
                    <a class='button tab-b tab-small' href='userpage.php'>Terug</a>
                    <h1>Wijzig order</h1>
                    <?php $db->getAndEditOrder($_GET['id']); ?>
                    <div id="edit_order">
                        <a class="button tab-b" href="php/editOrder_check.php?id=<?php echo $_GET['id']; ?>&type=Betaald">Betaald</a>
                        <a class="button tab-b" href="php/editOrder_check.php?id=<?php echo $_GET['id']; ?>&type=Verzonden">Verzonden</a>
                        <a class="button tab-b" href="php/editOrder_check.php?id=<?php echo $_GET['id']; ?>&type=Bezorgd">Bezorgd</a>
                        <a class="button tab-b" href="php/editOrder_check.php?id=<?php echo $_GET['id']; ?>&type=Geannuleerd">Annuleeren</a>
                    </div>
                </div>                
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>