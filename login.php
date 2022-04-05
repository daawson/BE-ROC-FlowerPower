<html>
    <?php include "php/head.php"; ?>
    <body>
        <?php         
            include "php/header.php";
            
            if(isset($_SESSION) && $_SESSION["logged_in"] === true){
                header("location: index.php");
            }

            
        ?>
        <div id="main-container" class="block-full">
            <div class="block-50">
                <form id="loginForm" action="php/login_check.php" method="POST">
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