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
    <link rel="stylesheet" href="/phpmotors/css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gemunu+Libre&display=swap" rel="stylesheet">
    <title>Update Review | phpmotors</title>
</head>
<body>
    <div class="con">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?> 
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?> 
        <div>
        <?php
            echo "
            <h1>$review[invMake] $review[invModel] Review</h1>
            <h2>Reviewed on $review[reviewDate]</h2>";
            ?>
            <?php
            if (isset($message)) {
                echo $message;
            }
        ?>
        <div id="edit-form">
            <form action="/phpmotors/reviews/index.php" method="post">
                <input type='hidden' name='action' value='updateReview'>
                <input type='hidden' name='reviewId' value="<?php echo $reviewId?>">
                <div>
                    <label for='reviewText'>Review Text</label>
                    <textarea name='reviewText' id='reviewText' required><?php echo $review['reviewText']; ?></textarea>
                </div>
                <button class='primary' type='submit'>Update</button>
            </form>
        </div>
        </div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?> 
    </div>
</body>
</html>