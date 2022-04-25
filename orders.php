<html>
    <?php include "php/head.php"; ?>
    <body>
    <?php         
            include "php/header.php";            
            if(isset($_SESSION) && $_SESSION["logged_in"] !== true || $_SESSION['user_level'] != "administrator"){
                header("location: index.php");
            }
            else{
                $userdata = $db->getUserData($_GET['id']);
            }
        ?>

        <div id="main-container">
            <div id="article-container">
                <div class="block-full flex-to-left">
                    <a class='button tab-b tab-small' href='userpage.php'>Terug</a>
                    <h1>Bestellingen van <?php echo $userdata['user_name'] . " " . $userdata['user_surname']; ?></h1>
                    <?php $db->getClientOrders($_GET['id']); ?>
                </div>                
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>