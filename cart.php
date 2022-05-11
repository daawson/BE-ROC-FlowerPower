<html>
    <?php include "php/head.php"; ?>
    <body>
    <?php         
            include "php/header.php";            
            if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
                header("location: login.php");
            }
            
        ?>

        <div id="main-container">
            <div class="block-to-left">
                <p>Welkom <?php echo $_SESSION['user_name'] ?>! </p>
                <?php if(isset($_GET['msg'])) echo "<p>".$_GET['msg']."</p>" ?>
                <div id="tabs-holder">
                    <div id="tabs">
                        <a class="button tab-b" onclick="openTab('cart')">Winkelwagen</a>

                    </div>

                    <div id="cart" class="tab-data">
                        <h2>Je winkelwagen</h2>
                            <?php 
                                $_SESSION['cart']->GetCartContent();
                            ?>
                    </div>

                </div>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>