<html>
    <?php include "php/head.php"; ?>
    <body>
        <?php include "php/header.php";                            
            if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
                header("location: index.php");
            }


            $db->placeOrder($_SESSION['user_id'], $_SESSION['cart']);
        ?>
        <div id="main-container">
            <div id="paygate">
                <p>Wachten op betaling...</p>
                <div class="lds-dual-ring"></div>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>