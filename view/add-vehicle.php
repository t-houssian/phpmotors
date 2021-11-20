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
    <title>Add Vehicle | phpmotors</title>
</head>
<body>
    <div class="con">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?>
        <div>
            <h1 class="vehicle-title">Add Vehicle</h1>
            <?php
            if (isset($message)) {
            echo $message;
            }
            ?>
            <form method="post" action="/phpmotors/vehicles/index.php">
                <?php echo $classificationList; ?><br><br>
                <label for="invMake">Make:</label><br>
                <input type="text" name="invMake" id="invMake" <?php if(isset($invMake)){echo "value='$invMake'";}  ?> required><br>
                <label for="invModel">Model:</label><br>
                <input type="text" name="invModel" id="invModel" <?php if(isset($invModel)){echo "value='$invModel'";}  ?> required><br><br>
                <label for="invDescription">Description:</label><br>
                <textarea name="invDescription" id="invDescription" required><?php if(isset($invDescription)){echo "$invDescription";}  ?></textarea><br><br>
                <label for="invImage">Image Path:</label><br>
                <input type="text" name="invImage" id="invImage" value="/images/vehicles/no-image.png" <?php if(isset($invImage)){echo "value='$invImage'";}  ?> required><br>
                <label for="invThumbnail">Thumbnail Path:</label><br>
                <input type="text" name="invThumbnail" id="invThumbnail" value="/images/vehicles/no-image.png" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?> required><br>
                <label for="invPrice">Price:</label><br>
                <input type="number" min="0.00" step="0.01" name="invPrice" id="invPrice" <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?> required><br>
                <label for="invStock">Stock:</label><br>
                <input type="number" name="invStock" id="invStock" <?php if(isset($invStock)){echo "value='$invStock'";}  ?> required><br>
                <label for="invColor">Color:</label><br>
                <input type="text" name="invColor" id="invColor" <?php if(isset($invColor)){echo "value='$invColor'";}  ?> required><br>
                <input type="submit" value="Add Vehicle"><br><br>
                <input type="hidden" name="action" value="add-vehicle">
            </form>
        </div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?> 
    </div>
</body>
</html>