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
    <title>Registration | phpmotors</title>
</head>
<body>
    <div class="con">
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?> 
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?> 
        <div>
            <h1>Sign Up!</h1>
            <?php
            if (isset($message)) {
            echo $message;
            }
            ?>
            <form method="post" action="/phpmotors/accounts/index.php">
                <label for="firstName">First Name:</label><br>
                <input type="text" name="clientFirstname" id="firstName" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> required><br>
                <label for="lastName">Last Name:</label><br>
                <input type="text" name="clientLastname" id="lastName" <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?> required><br>
                <label for="email">Email:</label><br>
                <input type="email" name="clientEmail" id="email" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required><br>
                <label for="psw">Password:</label><br>
                <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
                <input id="psw" type="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>
                <label for="show">Show Password</label>
                <input type="checkbox" name=show id="show" onclick="myFunction()"><br><br>
                <input type="submit" value="Sign Up"><br><br>
                <input type="hidden" name="action" value="register">
                <a  href='/phpmotors/accounts/index.php?action=registration'>No Account? Sign Up!</a>
            </form>
        </div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?> 
    </div>
    <script>
    function myFunction() {
        var x = document.getElementById("psw");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
</body>
</html>