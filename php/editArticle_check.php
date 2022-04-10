<?php 
    include 'database.php';

    // When request comes from POST Submit
    if(isset($_POST['Submit'])) {       
        if($_POST['Submit'] == 'Opslaan'){

            $articledata = array($_POST['article_name'],
                                $_POST['article_desc'],
                                $_POST['article_category'],
                                $_POST['article_tags'],
                                $_POST['article_stock'],
                                $_POST['article_price'],
                                $_POST['article_id']);

            $db->updateArticleData($articledata);
        }
        elseif($_POST['Submit'] == 'Verwijder'){
            $db->removeArticle($_POST['article_id']);
        }
    }
?>