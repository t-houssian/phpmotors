<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gemunu+Libre&display=swap" rel="stylesheet">
    <title>Home | phpmotors</title>
</head>
<body>
    <div class="con">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?> 
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?>
        <div>
            <h1>Welcome to PHP Motors!</h1>
        </div>
        <div class="container">
            <img src="images/vehicles/delorean.jpg" alt="Delorean Image" id="delorean">
            <div class="top-left">
                <h5>DMC Delorean</h5>
                <p>3 Cup holders</p>
                <p>Superman Ddoors</p>
                <p>Fuzzy dice</p>
            </div>
            <button>Own Today</button>
        </div>
        <div id="review">
            <h2>DMC Delorean Review</h2>
            <ul>
                <li>"So fast its almost like travling in time." (4/5)</li>
                <li>"Coolet ride on the road." (4/5)</li>
                <li>"I'm feeling Marty McFly!" (5/5)</li>
                <li>"The futuristic ride of our day." (5/5)</li>
                <li>"80's livin and I love it!" (5/5)</li>
            </ul>
        </div>
        <div class="upgrades">
            <h2>Delorean Upgrades</h2>
            <div class="grid-u">
                <div id="i1">
                    <div class="pic">
                        <img src="images/upgrades/flux-cap.png" alt="Flux Image">
                    </div>
                    <p>Flux Capacitor</p>
                </div>
                <div id="i2">
                    <div class="pic">
                        <img src="images/upgrades/flame.jpg" alt="Flame Image">
                    </div>
                    <p>Flame Decals</p>
                </div>
                <div id="i3">
                    <div class="pic">
                        <img src="images/upgrades/bumper_sticker.jpg" alt="Bumper Stiker Image">
                    </div>
                    <p>Bumper Stickers</p>
                </div>
                <div id="i4">
                    <div class="pic">
                        <img src="images/upgrades/hub-cap.jpg" alt="Hub Cap Image">
                    </div>
                    <p>Hub Caps</p>
                </div>
            </div>
        </div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </div>
</body>
</html>