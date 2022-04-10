<html>
    <?php include "php/head.php"; ?>
    <body>
    <?php         
            include "php/header.php";            
            if(isset($_SESSION) && $_SESSION["logged_in"] !== true){
                header("location: index.php");
            }
        ?>

        <div id="main-container">
            <div id="article-container">
                <div class="block-50">
                    <form id="article-data" class="article-data" action="php/addArticle_check.php" method="POST" enctype="multipart/form-data">                    
                    <a class="button tab-b tab-small" href="userpage.php">Terug</a>
                    <h1>Artikel toevoegen</h1>
                        Naam<input type="text" name="article_name" id="article_name" required>
                        Omschrijving<textarea  rows="4" cols="50" name="article_desc" id="article_desc" required></textarea>

                        Categorie
                        <select name="article_category" id="article_category">
                            <?php $db->getCategories(); ?>
                        </select>

                        Tags<input type="text" name="article_tags" id="article_tags" required>
                        Foto<input type="file" name="article_photoDir" id="article_photoDir" required accept="image/png, image/jpeg, image/jpg" />
                        Voorraad<input type="number" name="article_stock" id="article_stock" required>
                        Prijs<input pattern="(\d+\.\d{1,2})" type="text" name="article_price" id="article_price" required><br>
                        <input type="Submit" name="Submit" value="Toevoegen">
                    </form>
                </div>                
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>