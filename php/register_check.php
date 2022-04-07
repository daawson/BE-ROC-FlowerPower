<?php 
    include 'database.php';

    // When request comes from POST Submit
    if(isset($_POST['Submit'])) {       
        // Get all data

        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $adress = $_POST['adress'];
        $postcode = $_POST['postcode'];
        $phone = $_POST['phone'];

        $stmt = $dbh->prepare("SELECT * FROM user WHERE user_email=:uid");
        $stmt->bindParam(':uid', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                header("location: ../register.php?error=Dit email is al in gebruik!");
            }
            else{
                $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $dbh->prepare("INSERT INTO user (user_email, user_pass, user_name, user_surname, user_phone, user_adress, user_postcode, user_type) VALUES (?,?,?,?,?,?,?,?)");
                $stmt->execute(array($email, $hashedPass, $name, $surname, $phone, $adress, $postcode, "klant"));
                
                header("location: ../login.php?msg=Registreren gelukt! Nu kan je met je nieuwe account inlogen!");
            }
        }
    }
?>