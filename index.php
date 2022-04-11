<html>
    <?php include "php/head.php"; ?>
    <body>
        <?php include "php/header.php" ?>
        <div id="main-container">
            <div id="intro">
                    <div class="block-50">
                    <img class="round-img medium-img"src="img/flower_power_intro_header.png"/>
                    </div>
                <div class="block-50 flex-center-content">
                    <h1 class="intro-header">Flower Power</h1>
                    <p class="intro-text">
                        Flowers designed with your thoughts in mind.
                    </p>
                </div>
            </div>
            <div class="spacer"><h2 class="intro-header">Ons assortiment</h2></div>
            <div id="article_display">
                <?php $db->getArticlesDisplay() ?>
            </div>
        </div>
        <?php include 'php/footer.php'; ?>
    </body>
</html>