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
                <?php if(isset($_GET['msg'])) echo "<p>".$_GET['msg']."</p>" ?>
                <div id="tabs-holder">
                    <div id="tabs">
                        <a class="button tab-b" onclick="openTab('orders')">Bestellingen</a>
                        <a class="button tab-b" onclick="openTab('userdata')">Gegevens</a>

                        <?php if($_SESSION['user_level'] == "administrator"){ ?>
                            <a class="button tab-b" onclick="openTab('articles')">Artikelen</a>
                            <a class="button tab-b" onclick="openTab('users')">Gebruikers</a>
                        <?php } ?>

                    </div>

                    <div id="orders" class="tab-data">
                        <h2>Bestellingen</h2>
                        <div id="orders">
                            <?php 
                                $db->getClientOrders($_SESSION['user_id']);
                            ?>
                        </div>
                    </div>

                    <div id="userdata" class="tab-data" style="display:none">
                        <h2>Gegevens</h2>
                        <div id="userdata" class="block-50">
                            <?php
                                $db->getAndEditUserData($_SESSION['user_id']);
                            ?>
                        </div>
                    </div>

                    <?php if($_SESSION['user_level'] == "administrator"){ ?>
                        
                        <div id="articles" class="tab-data" style="display:none">
                            <h2>Artikelen</h2>
                            <div id="articles" class="block-full flex-dir-col flex-top-down">
                                <?php
                                    $db->getArticlesList();
                                ?>
                            </div>
                        </div>

                        <div id="users" class="tab-data" style="display:none">
                            <h2>Gebruikers</h2>
                            <div id="users" class="block-full flex-dir-col flex-top-down">
                                <?php
                                    $db->getUserList();
                                ?>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>