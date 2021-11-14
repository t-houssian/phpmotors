<?php
echo $_SESSION['loggedin'];
if (!isset($_SESSION['loggedin']) || !($_SESSION['clientData']['clientLevel'] > 1)) {
    header('Location: /phpmotors/index.php');
    exit;
}               
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/phpmotors/css/style.css">
    <link rel="stylesheet" href="/phpmotors/css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gemunu+Libre&display=swap" rel="stylesheet">
    <title><?php if(isset($invInfo['invMake'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?> | PHP Motors</title>
</head>
<body>
    <div class="con">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?>
        <div>
        <h1 class="vehicle-title"><?php if(isset($invInfo['invMake'])){ 
	        echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?></h1>
            <?php
            if (isset($message)) {
            echo $message;
            }
            ?>
            <form method="post" action="/phpmotors/vehicles/index.php">
                <?php echo $classificationList; ?><br><br>
                <label for="invMake">Make:</label><br>
                <input type="text" name="invMake" id="invMake" readonly <?php if(isset($invInfo['invMake'])){ echo "value='$invInfo[invMake]'"; } ?>><br>
                <label for="invModel">Model:</label><br>
                <input type="text" name="invModel" id="invModel" readonly <?php if(isset($invInfo['invModel'])){ echo "value='$invInfo[invModel]'"; } ?>><br><br>
                <label for="invDescription">Description:</label><br>
                <textarea name="invDescription" id="invDescription" readonly><?php if(isset($invInfo['invDescription'])){echo $invInfo['invDescription'];}  ?></textarea><br><br>
                <input type="submit" name="submit" value="Delete Vehicle"><br><br>
                <input type="hidden" name="action" value="deleteVehicle">
                <input type="hidden" name="invId" value="
                <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} ?>
                ">
            </form>
        </div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?> 
    </div>
</body>
</html>