<html>
    <?php include "php/head.php"; ?>
    <body>
        <?php include "php/header.php" ?>
        <div id="main-container">
            <div id="intro">
                    <div class="block-50">
                    <img class="round-img medium-img"src="img/flower_power_placeholder_bouquet.jpg"/>
                    </div>
                <div class="block-50">
                <img class="center-in-block small-img" src="img/flower_power_header_bouquet.png"/>
                    <h1>Flower Power</h1>
                    <p>Lorem Ipsum dolor sit amet</p>
                </div>
            </div>
            <div class="spacer"><h2>Onze assortiment</h2></div>
            <div id="article_display">
                <?php $db->getArticlesDisplay() ?>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>