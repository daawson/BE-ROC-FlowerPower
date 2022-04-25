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

        $userdata = array($email, $password, $name, $surname, $phone, $adress, $postcode, "klant");

        $db->registerUser($userdata);
    }
?>