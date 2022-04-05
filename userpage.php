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
                <p>Welcome <?php echo $_SESSION['user_name'] ?>! </p>
                <div id="tabs-holder">
                    <div id="tabs">
                        <a class="button tab-b" onclick="openTab('orders')">Bestellingen</a>
                        <a class="button tab-b" onclick="openTab('userdata')">Gegevens</a>
                    </div>

                    <div id="orders" class="tab-data">
                        <h2>Bestellingen</h2>
                        <div id="orders">
                        <?php 
                            $stmt = $dbh->prepare("SELECT * FROM orders WHERE order_client_id=:uid");
                            $stmt->bindParam(':uid', $_SESSION['user_id'], PDO::PARAM_STR);
                            
                            $stmt->execute();
                            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if(sizeof($orders) == 0){
                                echo "<p>Je hebt nog geen bestellingen!</p>";
                            }
                            else{
                                foreach($orders as $o){

                                    $stmt = $dbh->prepare("SELECT * FROM order_item WHERE order_ref_id=:uid");
                                    $stmt->bindParam(':uid', $o['order_id'], PDO::PARAM_STR);                                
                                    $stmt->execute();
                                    $order_item = $stmt->fetchAll(PDO::FETCH_ASSOC);  


                                    echo "<div class='table-item'><div class='table-cell'>".$o['order_id'].'</div>';                                    
                                    echo "<div class='table-cell'>";
                                    foreach($order_item as $oi){
                                        $stmt = $dbh->prepare("SELECT * FROM article WHERE article_id=:uid LIMIT 1");
                                        $stmt->bindParam(':uid', $oi['order_article_id'], PDO::PARAM_STR);                                
                                        $stmt->execute();
                                        $article = $stmt->fetch();

                                        echo $article['article_name']." x" . $oi['order_article_quantity'] . "<br>";
                                    }
                                    echo "</div><div class='table-cell'>€". $o['order_total'] ."</div>";
                                    echo "<div class='table-cell'><b><a href='#'>Factuur bekijken</a></b></div>";
                                    echo "<div class='table-cell'>".$o['order_status']."</div></div>";
                                }
                                
                            }
                        ?>
                        </div>
                    </div>

                    <div id="userdata" class="tab-data" style="display:none">
                        <h2>Gegevens</h2>
                        <p>Test test test</p> 
                    </div>
                </div>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>