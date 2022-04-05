<?php       
    require_once("php/database.php");         
    include("php/session.php");
?>
<div id="header">
    <a href="index.php" ><img src="img/flower_power_logo_black.png" id="logo"></img></a>
        <div id="ui">
            <a class="button">Contact</a>
            <?php 
                if(isset($_SESSION) && $_SESSION['logged_in'] == true){
                    echo '<a href="userpage.php" class="button">Mijn Profiel</a>';
                    echo '<a href="php/logout.php"class="button">Log uit</a>';
                }
                else{
                    echo '<a href="login.php"class="button">Login</a>';
                }
            ?>
    </div>
</div>