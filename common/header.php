<div id="grid-1">
    <img src="/phpmotors/images/site/logo.png" alt="Logo Images">
    <?php if (isset($_SESSION['loggedin'])) {
        $first = trim($_SESSION['clientData']['clientFirstname']);
        echo "<p id='button-span'><a id='button-1' href='/phpmotors/accounts/index.php'>$first</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a id='button-2' href='/phpmotors/accounts/index.php?action=Logout'>Logout</a></p>";
    }
    else {
        echo "<a id='button-span-main' href='/phpmotors/accounts/index.php?action=login'>My Account</a>";
    } ?>
</div>