<?php 
    include 'database.php';

    // When request comes from POST Submit
    if(isset($_POST['Submit'])) {       
        // Get all data

        $email = $_POST['email'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $adress = $_POST['adress'];
        $postcode = $_POST['postcode'];
        $phone = $_POST['phone'];
        $userlevel = $_POST['level'];
        $userid = $_POST['user_id'];

        $userdata = array($email, $name, $surname, $adress, $postcode, $phone, $userlevel, $userid);

        $db->updateUserData($userdata);
    }
?>