<?php 
    include 'database.php';

    // When request comes from POST Submit
    if(isset($_POST['Submit'])) {       


        // Get mail and password.
        $email = $_POST['email'];
        $password = $_POST['password'];   

        // Return if fields were empty.
        if (empty($email) || empty($password)) 
        {
            header("location: ../login.php?msg=Beide velden zijn verplicht!");
            exit();
        }   
        else    
        {       
            $db->loginUser(array($email, $password));
        }
     }
?>