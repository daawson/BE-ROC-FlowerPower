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
                    <?php
                    if(isset($_GET['error'])){
                        echo "<p>" .$_GET['error']. "</p>";
                    }                
                    ?>
                    Email<input min-length="6" max-length="64" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" type="email" name="email" id="email" required><br>
                    Wachtwoord<input min-length="4" max-length="32" type="password" name="password" id="password" required><br>
                    
                    Naam<input min-length="2" max-length="64" pattern="^(?=.{1,40}$)[a-zA-Z]+(?:[-'\s][a-zA-Z]+)*$" type="text" name="name" id="name" required><br>                    
                    Achternaam<input min-length="2" max-length="64" pattern="^(?=.{1,40}$)[a-zA-Z]+(?:[-'\s][a-zA-Z]+)*$" type="text" name="surname" id="surname" required><br>
                    
                    Adress<input min-length="4" max-length="128" placeholder="Jouwstraatnaam 12" pattern="^([1-9][e][\s])*([a-zA-Z]+(([\.][\s])|([\s]))?)+[1-9][0-9]*(([-][1-9][0-9]*)|([\s]?[a-zA-Z]+))?$" max-length="64" type="text" name="adress" id="adress" required><br>                    
                    Postcode<input max-length="7" placeholder="1234 AB" pattern="^([0-9]{4}[ ]+[a-zA-Z]{2})$" type="text" name="postcode" id="postcode" required><br>
                    
                    Telefoonnummer<input min-length="8" placeholder="+31 12345678" pattern="(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)" type="text" name="phone" id="phone" required><br>
                    <input type="submit" name="Submit" value="Registreer">
                   
                </form>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>