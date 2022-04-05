<?php

?>
<html>
    <head>
        <link href="css/style.css" rel="stylesheet"> </style>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    </head>
    <body>
        
        <?php         
            include "php/header.php";
            
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                header("location: index.php");
            }
        ?>

        <div id="main-container" class="block-full">
            <div class="block-50">
                <form id="loginForm" action="check.php" method="get">
                    Email<input type="email" name="email" id="email" required><br>
                    Wachtwoord<input type="password" name="password" id="password" required><br>
                    <input type="submit" name="Submit" value="Login">
                   
                </form>
                <p style="text-align: center">Geen account? <b><a href="register.php">Registreer!</a></b>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>