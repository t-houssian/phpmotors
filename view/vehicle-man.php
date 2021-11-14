<?php
if (!isset($_SESSION['loggedin']) || !($_SESSION['clientData']['clientLevel'] > 1)) {
    header('Location: /phpmotors/index.php');
    exit;
} 
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}              
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/phpmotors/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gemunu+Libre&display=swap" rel="stylesheet">
    <title>Vehicle Management | phpmotors</title>
</head>
<body>
    <div class="con">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?> 
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?> 
        <div>
            <h1>Vehicle Management</h1>
            <ul>
                <li><a href='/phpmotors/vehicles/index.php?action=classification'>Add Classification</a></li>
                <li><a href='/phpmotors/vehicles/index.php?action=vehicle'>Add Vehicle</a></li>
            </ul>
            <?php
            if (isset($message)) { 
            echo $message; 
            } 
            if (isset($classificationList)) { 
            echo '<h2>Vehicles By Classification</h2>'; 
            echo '<p>Choose a classification to see those vehicles</p>'; 
            echo $classificationList; 
            }
            ?>
            <noscript>
            <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
            </noscript>
            <table id="inventoryDisplay"></table>
        </div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?> 
    </div>
<script src="../js/inventory.js"></script>
</body>
</html>
<?php unset($_SESSION['message']); ?>
