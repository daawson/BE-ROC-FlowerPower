<?php
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
            foreach($orders as $o)
            {
                $stmt = $this->dbh->prepare("SELECT * FROM order_item WHERE order_ref_id=:uid");
                $stmt->bindParam(':uid', $o['order_id'], PDO::PARAM_STR);                                
                $stmt->execute();
                $order_item = $stmt->fetchAll(PDO::FETCH_ASSOC);  

                echo "<div class='table-item'><div class='table-cell'>".$o['order_id'].'</div>';                                    
                echo "<div class='table-cell'>";

                foreach($order_item as $oi){
                    $stmt = $this->dbh->prepare("SELECT * FROM article WHERE article_id=:uid LIMIT 1");
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
    }

    function getAndEditUserData($user_id){
        $stmt = $this->dbh->prepare("SELECT * FROM user WHERE user_id=:uid LIMIT 1");
        $stmt->bindParam(':uid', $user_id, PDO::PARAM_STR);                                
        $stmt->execute();
        $userdata = $stmt->fetch();

        echo "<form id='userdata-table' class='userdata' action='php/update_check.php' method='POST'>";
            echo "Naam<input min-length='2' max-length='64' pattern=\"^(?=.{1,40}$)[a-zA-Z]+(?:[-'\s][a-zA-Z]+)*$\" type='text' name='name' id='name' required value='".$userdata['user_name']."'>";
            echo "Achternaam<input min-length='2' max-length='64' pattern=\"^(?=.{1,40}$)[a-zA-Z]+(?:[-'\s][a-zA-Z]+)*$\" type='text' name='surname' id='surname' required value='".$userdata['user_surname']."'>";
            echo "E-Mail<input min-length='6' max-length='64' pattern='^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$' type='email' name='email' id='email' required value='".$userdata['user_email']."'>";
            echo "Telefoonnummer<input min-length='8' pattern='(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)' type='text' name='phone' id='phone' required value='".$userdata['user_phone']."'>";
            echo "<br><p>Bezorg details</p><br>";
            echo "Adress<input min-length='4' max-length='128' pattern='^([1-9][e][\s])*([a-zA-Z]+(([\.][\s])|([\s]))?)+[1-9][0-9]*(([-][1-9][0-9]*)|([\s]?[a-zA-Z]+))?$' type='text' name='adress' id='adress' required value='".$userdata['user_adress']."'>";
            echo "Postcode<input max-length='7' placeholder='1234 AB' pattern='^([0-9]{4}[ ]+[a-zA-Z]{2})$' type='text' name='postcode' id='postcode' required value='".$userdata['user_postcode']."'>";
            echo "<input type='hidden' id='user_id' name='user_id' value='".$_SESSION['user_id']."'>";
            echo "<input type='submit' name='Submit' value='Opslaan'>";
        echo "</form>";
    }

    function updateUserData($userdata){
        $stmt = $this->dbh->prepare("UPDATE user SET user_email=?, user_name=?, user_surname=?, user_adress=?, user_postcode=?, user_phone=? WHERE user_id=?");
        if($stmt->execute($userdata)){
            header("location: ../userpage.php?msg=Uw gegevens zijn opgeslagen!");
        }
        //header("location: ../userpage.php?msg=Uw gegevens zijn opgeslagen!");
    }

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

    function getArticlesList(){
        $stmt = $this->dbh->prepare("SELECT * FROM article");
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($articles as $article){
            echo "<div class='table-item'>";
            echo "<div class='table-cell'>".$article['article_id'].'</div>';           
            echo "<div class='table-cell'>". $article['article_name'] ."</div>"; 
            // echo "<div class='table-cell'>". $article['article_desc'] ."</div>"; 
            echo "<div class='table-cell'>". $article['article_category'] ."</div>"; 
            echo "<div class='table-cell'>". $article['article_tags'] ."</div>"; 
            echo "<div class='table-cell'>". $article['article_price'] ."</div>";     
            echo "<div class='table-cell'>". $article['article_stock'] ."</div>";        
            echo "<div class='table-cell'><b><a href='#'>Aanpassen</a></b></div>";
            echo "</div>";
        }
    }

    function getArticle($id){
        $stmt = $this->dbh->prepare("SELECT * FROM article WHERE article_id=:uid LIMIT 1");
        $stmt->bindParam(':uid', $id, PDO::PARAM_STR);                                
        $stmt->execute();
        $article = $stmt->fetch();

        return $article;
    }

    function getUserList(){
        $stmt = $this->dbh->prepare("SELECT * FROM user");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($users as $user){
            echo "<div class='table-item'>";
            echo "<div class='table-cell'>".$user['user_id'].'</div>';   
            echo "<div class='table-cell'>".$user['user_name'].'</div>';  
            echo "<div class='table-cell'>".$user['user_surname'].'</div>';  
            echo "<div class='table-cell'>".$user['user_type'].'</div>';     
            echo "<div class='table-cell'><b><a href='#'>Aanpassen</a></b></div>";
            echo "</div>";
        
        }
    }
}   

$db = new Database();