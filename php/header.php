<?php 
require_once("php/database.php");   
    function is_session_started()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    if ( is_session_started() === FALSE ){
        session_start();
        $_SESSION['loggedin'] = false;
    }

    
    
?>
<div id="header">
    <img href="../index.php" src="img/flower_power_logo_black.png" id="logo"></img>
        <div id="ui">
            <a class="button">Contact</a>
            <?php 
                if($_SESSION['loggedin'] == true){
                    echo '<a href="userpage.php" class="button">My Profile</a>';
                }
                else{
                    echo '<a href="login.php"class="button">Login</a>';
                }
            ?>
    </div>
</div>