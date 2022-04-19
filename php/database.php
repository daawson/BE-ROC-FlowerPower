<?php
require 'shoppingcart.php';
class Database
{
    public $dbh;

    function __construct() {
        $host = 'localhost';
        $port = '3306';
        $user = 'root';
        $pass = '';
        $db = 'flowerpower';
        $this->dbh = new PDO('mysql:host='.$host.';dbname='.$db.';port='.$port, $user, $pass);
    }

    // Logins the user.
    function loginUser($userdata){
        $stmt = $this->dbh->prepare("SELECT * FROM user WHERE user_email=:uid");
        $stmt->bindParam(':uid', $userdata[0], PDO::PARAM_STR);
        
        // Start search
        if ($stmt->execute()) {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //Dehash the password
                $hashPasswordBool = password_verify($userdata[1], $row['user_pass']);

                //Wrong? Go back to login.
                if ($hashPasswordBool == false) {
                    header("location: ../login.php");
                    exit();                
                } 
                // Right? You're now logged in!.
                elseif ($hashPasswordBool == true) 
                {
                    session_start();
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];
                    $_SESSION['user_level'] = $row['user_type'];
                    $_SESSION['logged_in'] = true;                    
                    $_SESSION['cart'] = new Cart();    
                    header("location: ../index.php");
                    exit();
                }
            }
            else{
                header("location: ../login.php?msg=Ongeldige gebruikersnaam of wachtwoord!");
                exit();
            }
        }
    }

    // Registers user.
    function registerUser($userdata){

        $stmt = $this->dbh->prepare("SELECT * FROM user WHERE user_email=:uid");
        $stmt->bindParam(':uid', $userdata[0], PDO::PARAM_STR);

        if ($stmt->execute()) {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                header("location: ../register.php?error=Dit email is al in gebruik!");
            }
            else{
                $hashedPass = password_hash($userdata[1], PASSWORD_DEFAULT);
                $userdata[1] = $hashedPass;
                $stmt = $this->dbh->prepare("INSERT INTO user (user_email, user_pass, user_name, user_surname, user_phone, user_adress, user_postcode, user_type) VALUES (?,?,?,?,?,?,?,?)");
                $stmt->execute($userdata);
                
                header("location: ../login.php?msg=Registreren gelukt! Nu kan je met je nieuwe account inlogen!");
            }
        }
    }

    // Returns order list.
    function getClientOrders($user_id){
        $stmt = $this->dbh->prepare("SELECT * FROM orders WHERE order_client_id=:uid");
        $stmt->bindParam(':uid', $user_id, PDO::PARAM_STR);

        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(sizeof($orders) == 0)
        {
            echo "<p>Je hebt nog geen bestellingen!</p>";
        }
        else
        {   
            echo "<table class='data-table'><tr><th>Bestellingnummer</th><th>Artikelen</th><th>Totaal prijs</th><th>Factuur</th><th>Status</th></tr>";
            foreach($orders as $o)
            {
                $stmt = $this->dbh->prepare("SELECT * FROM order_item WHERE order_ref_id=:uid");
                $stmt->bindParam(':uid', $o['order_id'], PDO::PARAM_STR);                                
                $stmt->execute();
                $order_item = $stmt->fetchAll(PDO::FETCH_ASSOC);  
                
                
                echo "<tr><td>".$o['order_id']."</td>";
                echo "<td>";

                foreach($order_item as $oi){
                    $stmt = $this->dbh->prepare("SELECT * FROM article WHERE article_id=:uid LIMIT 1");
                    $stmt->bindParam(':uid', $oi['order_article_id'], PDO::PARAM_STR);                                
                    $stmt->execute();
                    $article = $stmt->fetch();

                    if(isset($article['article_name']))
                        echo $article['article_name']." x" . $oi['order_article_quantity'] . "<br>";
                    else
                        echo "Onbekende artikel x" . $oi['order_article_quantity'] . "<br>";
                }
                echo "</td>";
                echo "<td>€". $o['order_total'] ."</td>";
                echo "<td><b><a href='#'>Factuur bekijken</a></b></td>";
                echo "<td>".$o['order_status']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    // Gets and Form-ats chosen by ID values.
    function getAndEditUserData($user_id, $admin){
        $stmt = $this->dbh->prepare("SELECT * FROM user WHERE user_id=:uid LIMIT 1");
        $stmt->bindParam(':uid', $user_id, PDO::PARAM_STR);                                
        $stmt->execute();
        $userdata = $stmt->fetch();

        echo "<form id='userdata-table' class='userdata' action='php/update_check.php' method='POST'>";
        
            // echo "<a class='button tab-b tab-small' href='userpage.php'>Terug</a>";
            echo "Naam<input min-length='2' max-length='64' pattern=\"^(?=.{1,40}$)[a-zA-Z]+(?:[-'\s][a-zA-Z]+)*$\" type='text' name='name' id='name' required value='".$userdata['user_name']."'>";
            echo "Achternaam<input min-length='2' max-length='64' pattern=\"^(?=.{1,40}$)[a-zA-Z]+(?:[-'\s][a-zA-Z]+)*$\" type='text' name='surname' id='surname' required value='".$userdata['user_surname']."'>";
            echo "E-Mail<input min-length='6' max-length='64' pattern='^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$' type='email' name='email' id='email' required value='".$userdata['user_email']."'>";
            echo "Telefoonnummer<input min-length='8' pattern='(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)' type='text' name='phone' id='phone' required value='".$userdata['user_phone']."'>";
            echo "<br><p>Bezorg details</p><br>";
            echo "Adress<input min-length='4' max-length='128' pattern='^([1-9][e][\s])*([a-zA-Z]+(([\.][\s])|([\s]))?)+[1-9][0-9]*(([-][1-9][0-9]*)|([\s]?[a-zA-Z]+))?$' type='text' name='adress' id='adress' required value='".$userdata['user_adress']."'>";
            echo "Postcode<input max-length='7' placeholder='1234 AB' pattern='^([0-9]{4}[ ]+[a-zA-Z]{2})$' type='text' name='postcode' id='postcode' required value='".$userdata['user_postcode']."'>";
            
            if($admin == 1){
                //echo "Toegang level<input min-length='2' max-length='64' pattern=\"^(?=.{1,40}$)[a-zA-Z]+(?:[-'\s][a-zA-Z]+)*$\" type='text' name='level' id='level' required value='".."'>";
                echo "<select name='level' id='level'><option value='klant'"; 
                    if($userdata['user_type'] == 'klant') echo 'selected';
                    echo ">Klant</option>";
                    echo "<option value='administrator'";
                    if($userdata['user_type'] == 'administrator') echo 'selected'; 
                    echo ">Administrator</option></select>";
            }
            else{
                echo "<input type='hidden' id='level' name='level' value='".$userdata['user_type']."'>";
            }

            echo "<input type='hidden' id='user_id' name='user_id' value='".$user_id."'>";
            echo "<input type='submit' name='Submit' value='Opslaan'>";
        echo "</form>";
    }

    // Updates user data.
    function updateUserData($userdata){
        $stmt = $this->dbh->prepare("UPDATE user SET user_email=?, user_name=?, user_surname=?, user_adress=?, user_postcode=?, user_phone=?, user_type=? WHERE user_id=?");
        if($stmt->execute($userdata)){
            if($_SESSION['user_id'] == $userdata[7]){
                $_SESSION['user_level'] = $userdata[6];
            }
            header("location: ../userpage.php?msg=Uw gegevens zijn opgeslagen!");

        }
    }

    // Formats all articles into a display 'case';
    function getArticlesDisplay(){
        $stmt = $this->dbh->prepare("SELECT * FROM article");
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(sizeof($articles) == 0)
        {
            echo "<p>We hebben geen artikelen</p>";
        }
        else
        {
            foreach($articles as $article){
                echo "<div class='article-box'>";
                echo "<img src='".$article['article_photoDir']."'>";
                echo "<p class='article-name'>".$article['article_name']."</p>";                
                echo "<p class='article-desc'>".$article['article_desc']."</p>";
                echo "<p class='article-price'>€".$article['article_price']."</p>";
                echo "<div onclick=\"location.href='article.php?id=".$article['article_id']."'\" class='article-redirect'>Bekijk</div>";
                echo "</div>";
            }
        }
    }

    // Gets and formats users into a table/list.
    function getArticlesList(){
        $stmt = $this->dbh->prepare("SELECT * FROM article");
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<table class='data-table'><tr><th>Article ID</th><th>Artikelnaam</th><th>Categorie</th><th>Tags</th><th>Prijs</th><th>Voorraad</th><th>Aanpassen</th></tr>";
        foreach($articles as $article){
            
            echo "<tr>";
            echo "<td>".$article['article_id'].'</td>';           
            echo "<td><a href='article.php?id=". $article['article_id'] ."'>".$article['article_name']."</a></td>"; 
            // echo "<div class='table-cell'>". $article['article_desc'] ."</div>"; 
            echo "<td>". $article['article_category'] ."</td>"; 
            echo "<td>". $article['article_tags'] ."</td>"; 
            echo "<td>€". $article['article_price'] ."</td>";     
            echo "<td>". $article['article_stock'] ."</td>";        
            echo "<td><b><a href='editArticle.php?id=".$article['article_id']."'><i class='fa-solid fa-pen-to-square'></i></a></b></td>";
            echo "</tr>";            
            
        }
        echo "</table>";
    }

    // Returns array of values of an selected by the id article.
    function getArticle($id){
        $stmt = $this->dbh->prepare("SELECT * FROM article WHERE article_id=:uid LIMIT 1");
        $stmt->bindParam(':uid', $id, PDO::PARAM_STR);                                
        $stmt->execute();
        $article = $stmt->fetch();

        return $article;
    }

    // Gets and formats users into a table.
    function getUserList(){
        $stmt = $this->dbh->prepare("SELECT * FROM user");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<table class='data-table'><tr><th>Gebruiker ID</th><th>Naam</th><th>Achternaam</th><th>Level</th><th>Aanpassen</th></tr>";
        foreach($users as $user){
            echo "<tr>";
            echo "<td>".$user['user_id'].'</td>';   
            echo "<td>".$user['user_name'].'</td>';  
            echo "<td>".$user['user_surname'].'</td>';  
            echo "<td>".$user['user_type'].'</td>';     
            echo "<td><b><a href='editUser.php?id=".$user['user_id']."'><i class='fa-solid fa-pen-to-square'></i></a></b></td>";            
            echo "</tr>";
        }
        echo "</table>";
    }

    // Returns the categories as option list.
    // Needs a <select> tag before and after this function.
    function getCategories(){
        $stmt = $this->dbh->prepare("SELECT * FROM categories");
        $stmt->execute();
        $category = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($category as $c){
            echo '<option value="'.$c['category'].'">'.$c['category'].'</option>';        
        }
    }

    //Adds the article into the database.
    function addArticle($articledata){
        $stmt = $this->dbh->prepare("INSERT INTO article (article_name, article_desc, article_category, article_tags, article_photoDir, article_stock, article_price) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute($articledata);
        
        $stmt = $this->dbh->prepare("SELECT * FROM article WHERE article_name=:uid LIMIT 1");
        $stmt->bindParam(':uid', $articledata[0], PDO::PARAM_STR);   
        $stmt->execute();
        $article = $stmt->fetch();

        header("location: ../article.php?id=".$article['article_id']);

    }

    // Get and Form-at article data and fill it with values.
    function getAndEditArticleData($article_id){
        $stmt = $this->dbh->prepare("SELECT * FROM article WHERE article_id=:uid LIMIT 1");
        $stmt->bindParam(':uid', $article_id, PDO::PARAM_STR);                                
        $stmt->execute();
        $articledata = $stmt->fetch();

        echo "<form id='article-data' class='article-data' action='php/editArticle_check.php' method='POST' enctype='multipart/form-data'>";    
            echo "<a class='button tab-b tab-small' href='userpage.php'>Terug</a>";
            echo "<h1>Artikel wijzigen</h1>";
            echo "Naam<input type='text' name='article_name' id='article_name' value='".$articledata['article_name']."' required>";
            echo "Omschrijving<textarea  rows='4' cols='50' name='article_desc' id='article_desc' required>". $articledata['article_desc']."</textarea>";
            echo "Categorie<select name='article_category' id='article_category'>";
            $this->getCategories(); 
            echo "</select>";
            // echo "<img src='".$articledata['article_photoDir']."'>";
            echo "Foto<input type='file' name='article_photoDir' id='article_photoDir' value='".$articledata['article_photoDir']."' accept='image/png, image/jpeg, image/jpg' />";
            echo "Tags<input type='text' name='article_tags' id='article_tags' value='".$articledata['article_tags']."' required>";
            echo "Voorraad<input type='number' name='article_stock' id='article_stock' value='".$articledata['article_stock']."' required>";
            echo "Prijs<input type='text' name='article_price' id='article_price' value='".$articledata['article_price']."' required>";
            echo "<input type='hidden' name='article_id' id='article_id' value='".$articledata['article_id']."'>";            
            echo "<input type='hidden' name='article_firstPhotoDir' id='article_firstPhotoDir' value='".$articledata['article_photoDir']."'>";
            echo "<input type='submit' name='Submit' value='Opslaan'/>";
            echo "<input type='submit' name='Submit' value='Verwijder'/>";
        echo "</form>";
    }

    // Update the article
    function updateArticleData($articledata){
        $stmt = $this->dbh->prepare("UPDATE article SET article_name=?, article_desc=?, article_category=?, article_tags=?, article_photoDir=?, article_stock=?, article_price=? WHERE article_id=?");
        if($stmt->execute($articledata)){
            header("location: ../userpage.php?msg=Artikel is opgeslagen!");

        }
    }

    // Remove article from database by article_id
    function removeArticle($article_id){
        $stmt = $this->dbh->prepare("DELETE FROM article WHERE article_id=:uid");
        $stmt->bindParam(':uid', $article_id, PDO::PARAM_INT);
        if($stmt->execute()){
            header("location: ../userpage.php?msg=Artikel is verwijderd!");

        }
    }
}   

// Creates the database instance.
$db = new Database();