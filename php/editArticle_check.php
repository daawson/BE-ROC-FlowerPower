<?php 
    include 'database.php';

    if(isset($_POST["Submit"])) {
        // if(basename($_FILES["article_photoDir"]["name"]) !== null){
        if(isset($_FILES["article_photoDir"]) && !empty( $_FILES["article_photoDir"]["name"] )){
            $target_dir = "../article_images/";
            $target_file = $target_dir . basename($_FILES["article_photoDir"]["name"]);
            $uploadOk = 1;
            $errorMsg = "";
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["article_photoDir"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $errorMsg = "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $errorMsg = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["article_photoDir"]["size"] > 500000) {
                $errorMsg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $errorMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $errorMsg = "Sorry, your file was not uploaded.";
                } else {
                if (move_uploaded_file($_FILES["article_photoDir"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["article_photoDir"]["name"])). " has been uploaded.";
                } else {
                    // $errorMsg = "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
    
    // When request comes from POST Submit
    if(isset($_POST['Submit'])) {       
        if($_POST['Submit'] == 'Opslaan'){

            // if(basename($_FILES["article_photoDir"]["name"]) !== null){ 
            if(isset($_FILES["article_photoDir"]) && !empty( $_FILES["article_photoDir"]["name"] )){
                $articledata = array($_POST['article_name'],
                                    $_POST['article_desc'],
                                    $_POST['article_category'],
                                    $_POST['article_tags'],
                                    "article_images/".basename($_FILES["article_photoDir"]["name"]),
                                    $_POST['article_stock'],
                                    $_POST['article_price'],
                                    $_POST['article_id']);
            }
            else{
                $articledata = array($_POST['article_name'],
                                    $_POST['article_desc'],
                                    $_POST['article_category'],
                                    $_POST['article_tags'],
                                    $_POST['article_firstPhotoDir'],
                                    $_POST['article_stock'],
                                    $_POST['article_price'],
                                    $_POST['article_id']);
            }


            
            $db->updateArticleData($articledata);
        }
        elseif($_POST['Submit'] == 'Verwijder'){
            $db->removeArticle($_POST['article_id']);
        }
    }
?>