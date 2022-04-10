<?php       
    require_once("php/database.php");         
    include("php/session.php");
?>
<div id="header">
    <a href="index.php" ><img src="img/flower_power_logo_black.png" id="logo"></img></a>
        <div id="ui">
            <a class="button">Contact <i class="fa-solid fa-address-card"></i></a>
            <?php 
                if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
                    echo '<a href="userpage.php" class="button">Mijn Profiel <i class="fa-solid fa-users-gear"></i></a>';
                    echo '<a href="php/logout.php" class="button">Log uit <i class="fa-solid fa-arrow-right-to-bracket"></i></a>';
                }
                else{
                    echo '<a href="login.php" class="button">Login<i class="fa-solid fa-arrow-right-from-bracket"></i></a>';
                }
            ?>
    </div>
</div>