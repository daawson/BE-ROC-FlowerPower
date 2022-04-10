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
                <div class="block-50">
                    <h1>Wijzig gebruiker gegevens</h1>
                    <a class="button tab-b tab-small" href="userpage.php">Terug</a>
                    <?php $db->getAndEditUserData($_GET['id'], $admin); ?>
                </div>                
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>