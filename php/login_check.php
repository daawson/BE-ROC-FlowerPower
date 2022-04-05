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
            header("location: ../login.php");
            exit();
        }   
        else    
        {       
            // Prepare the statement. search for email('login')  
            $stmt = $dbh->prepare("SELECT * FROM user WHERE user_email=:uid");
            $stmt->bindParam(':uid', $email, PDO::PARAM_STR);
            
            // Start search
            if ($stmt->execute()) {
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Dehash the password
                    $hashPasswordBool = password_verify($password, $row['user_pass']);

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
            } 
            else 
            {
                header("location: ../login.php");
                exit();                
            }
        }
     }
?>