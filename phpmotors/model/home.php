<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../phpmotors/css/styles.css" media="screen">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class = "page-wrapper">
            <header>
                <a href="/CS%20340/phpmotors/index.php"><img class="logo" src="images/site/logo.png" alt="logo"></a>
                <?php 
                    if($_SESSION['loggedin']){
                        $clientName = $_SESSION['clientData']['clientFirstname'];
                        echo "<span>Welcome $clientName</span>";
                    } 
                ?><a href="/CS%20340/phpmotors/accounts/?action=Login">My Account</a>
            </header>
            <nav class="nav-bar"> 
                <?php echo $navList;?>
            </nav>
            <main>
                <h1>Welcome to PHP Motors!</h1>
                <div class = "image">
                    <div class = "content">
                        <h2>DMC Delorean</h2>
                        <p>3 Cup holders</p>
                        <p>Superman doors</p>
                        <p>Fuzzy dice!</p>
                        <button type="button" id="bg-btn">Own Today</button>
                    </div>
                    <button type="button" id="sm-btn">Own Today</button>
                </div>
                <div class="big-grid">
                    <div class = "reviews">
                        <h2>DMC Delorean Reviews</h2>
                        <ul>
                            <li><p>"So fast it's almost like traveling in time." (4/5)</p></li>
                            <li><p>"Coolest ride on the road." (4/5)</p></li>
                            <li><p>"I'm feeling Marty McFly!" (5/5)</p></li>
                            <li><p>"The most futuristic ride of our day." (4/5)</p></li>
                            <li><p>"80's livin and I love it!" (5/5)</p></li>
                        </ul>
                    </div>
                    <div class="upgrades">
                        <h2>Delorean Upgrades</h2>
                        <div class = "up-grid">
                            <div class = "grid-element">
                                <div class = "element-box">
                                    <img src = "../phpmotors/images/upgrades/flux-cap.png" alt="flux capacitor">
                                </div>
                                <a href="#">Flux Capacitor</a>
                            </div>
                            <div class = "grid-element">
                                <div class = "element-box">
                                    <img src = "../phpmotors/images/upgrades/flame.jpg" alt="Flame">
                                </div>
                                <a href="#">Flame Decals</a>
                            </div>
                            <div class = "grid-element">
                                <div class = "element-box">
                                    <img src = "../phpmotors/images/upgrades/bumper_sticker.jpg" alt="bumper sticker">
                                </div>
                                <a href="#">Bumper Stickers</a>
                            </div>
                            <div class = "grid-element">
                                <div class = "element-box">
                                    <img src = "../phpmotors/images/upgrades/hub-cap.jpg" alt="hub cap">
                                </div>
                                <a href="#">Hub Caps</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>