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
                <form id="loginForm" class="register" action="php/register_check.php" method="POST">
                    Email<input type="email" name="email" id="email" required><br>
                    Wachtwoord<input type="password" name="password" id="password" required><br>
                    
                    Naam<input type="password" name="password" id="password" required><br>                    
                    Achternaam<input type="password" name="password" id="password" required><br>
                    
                    Adress<input type="password" name="password" id="password" required><br>                    
                    Postcode<input type="password" name="password" id="password" required><br>
                    
                    Telefoonnummer<input type="password" name="password" id="password" required><br>
                    <input type="submit" name="Submit" value="Registreer">
                   
                </form>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>