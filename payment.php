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
            <div class="block-to-left">
                <div class="block-full">
                    <!-- <div id="payment" class="tab-data"> -->
                        <div class="block-full flex-dir-col">
                            <p>Kies je bank</p>
                            <select>
                                <option>ING</option>
                                <option>ABN Amro</option>
                                <option>Rabobank</option>
                                <option>SVN</option>
                                <option>De Volksbank</option>
                            </select>
                            <a class="button tab-b" href="paygate.php">Betaal</a>
                        </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>