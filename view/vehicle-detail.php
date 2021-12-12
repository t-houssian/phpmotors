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
    <title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
</head>
<body>
    <div class="con">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?> 
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?> 
        <h1><?php echo $vehicle['invMake'].' '.$vehicle['invModel']; ?></h1>
        <div id="all-info">
        <?php if(isset($vehicleDetails)){
            echo $vehicleDetails;
        } 
        //Display vehicle thumbnails view
        if (isset($thumbnailsView)) {
            echo $thumbnailsView;
        }
        ?>
        <h2>Customer Reviews</h2>
        <?php
        if (!isset($_SESSION['loggedin'])) {
            echo "<p>You must <a href='/phpmotors/accounts/index.php?action=login'>login</a> to write a review</p>";
        }
        else {
            $vehicleName = $vehicle['invMake'].' '.$vehicle['invModel'];
            echo "<h3>Review the $vehicleName</h3>";

            if (isset($messageReview)) {
                echo $messageReview;
            }

            echo '
            <div id="review-form">
            <form action="/phpmotors/reviews/index.php" method="post">
                <div>
                    <label for="screenName">Screen Name</label>
                    <input type="text" name="screenName" id="screenName" value = "' . $screenName . '" disabled>
                </div>
                <div>
                    <label for="reviewText">Review</label>
                    <textarea class="txtarea" name="reviewText" id="reviewText" required></textarea>
                </div>
                <input type="hidden" name="action" value="addReview">
                <input type="hidden" name="invId" value="' . $vehicle['invId'] . '">
                <input type="hidden" name="invMake" value="' . $vehicle['invMake'] . '">
                <input type="hidden" name="invModel" value="' . $vehicle['invModel'] . '">
                <input type="hidden" name="clientId" value="' . $_SESSION['clientData']['clientId'] . '">
                <button class="primary" type="submit">Submit Review</button>
            </form>
            </div>
            ';
        }
        echo "<h3>Reviews</h3>";
        echo $firstReview;
        echo $reviewsDetailDisplay;
        ?>       
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?> 
    </div>
</body>
</html> 