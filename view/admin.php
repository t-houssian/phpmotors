<?php
if (!isset($_SESSION['loggedin'])) {
    header('Location: /phpmotors/index.php');
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
    <title>Admin | phpmotors</title>
</head>
<body>
    <div class="con">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?> 
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?> 
        <div>
            <?php
                $first = $_SESSION['clientData']['clientFirstname'];
                $last = $_SESSION['clientData']['clientLastname'];
                echo "<h1>$first $last</h1>";     
            ?>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <p>&nbsp;You are Logged in</p>
            <ul>
                <li>First Name: <?php echo $_SESSION['clientData']['clientFirstname'];?></li>
                <li>Last Name: <?php echo $_SESSION['clientData']['clientLastname'];?></li>
                <li>Email: <?php echo $_SESSION['clientData']['clientEmail'];?></li>
            </ul>
            <?php if($_SESSION['clientData']['clientLevel'] > 1) {
                    echo "<h2>Inventory Management</h2>";
                    echo "<h3>Use this link to manage inventory</h3>";
                    echo "<p><a id='update-accounts' href='/phpmotors/vehicles/index.php'>Vehicle Management</a></p>";
            } ?>  
            <a id='update-accounts' href='/phpmotors/accounts/index.php?action=client-update'>Update Account Information</a>
            <h3>Manage Your Product Reviews</h3>
            <ul>
            <?php echo $reviewsDisplay; ?>
            </ul>
        </div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?> 
    </div>
</body>
</html>