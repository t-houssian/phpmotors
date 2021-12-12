<?php
// this is the accounts controller for the site

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the reviews model
require_once '../model/reviews-model.php';

$classifications = getClassifications();
$navList = buildNav($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action){
    case 'registration':
		include '../view/registration.php';
		break;
	case 'login':
		include '../view/login.php';
		break;
    case 'register':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if($existingEmail){
            $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        // Check for missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit; 
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if($regOutcome === 1){
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }

        
        break;

    case 'client-update':
        $clientInfo = $_SESSION['clientData'];
        include '../view/client-update.php';
        break;

    case 'update-account':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientEmail = checkEmail($clientEmail);
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        
        if ($clientEmail != $_SESSION['clientData']['clientEmail']){
            $existingEmail = checkExistingEmail($clientEmail);
            // Check for existing email address in the table
            if($existingEmail){
                $message = '<p class="notice">That email address already exists.</p>';
                include '../view/client-update.php';
                exit;
            }
        }

        // Check for missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit; 
        }

        $updateResult = updateAccount($clientId, $clientFirstname, $clientLastname, $clientEmail);

        $_SESSION['clientData'] = getClient2($clientId);

        // Check and report the result
        if ($updateResult) {
            $message = "<p class='vehicle-title'>Congratulations, your account was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/accounts/index.php');
            exit;
        } else {
            $message = '<p class="vehicle-title">Sorry but the update failed. Please try again.</p>';
            include '../view/client-update.php';
            exit;
        }

        
        break;

    case 'update-password':
        // Filter and store the data
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if(empty($checkPassword)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit; 
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $updateResult = updatePassword($clientId, $hashedPassword);

        // Check and report the result
        if ($updateResult) {
            $message = "<p class='vehicle-title'>Congratulations, your account was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/accounts/index.php');
            exit;
        } else {
            $message = '<p class="vehicle-title">Sorry but the update failed. Please try again.</p>';
            include '../view/client-update.php';
            exit;
        }

    case 'Login':
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        if(empty($clientEmail) || empty($checkPassword)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/login.php';
            exit; 
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if(!$hashCheck) {
        $message = '<p class="notice">Please check your password and try again.</p>';
        include '../view/login.php';
        exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;

        $clientId = $_SESSION['clientData']['clientId'];
        $reviews = getReviewByClient($clientId);

        // Get Reviews
        $reviewsDisplay = "";
        foreach ($reviews as $key => $review) {
            $reviewsDisplay .= getReviewListView($review);
        }
        if($reviewsDisplay == ""){
            $reviewsDisplay = '<p>No Reviews Found<p>';
        }

        // Send them to the admin view
        include '../view/admin.php';
        exit;

        break;

    case 'Logout':
        session_destroy();
        header('Location: /phpmotors/accounts/index.php');
    default:

        $clientId = $_SESSION['clientData']['clientId'];
        $reviews = getReviewByClient($clientId);

        // Get Reviews
        $reviewsDisplay = "";
        foreach ($reviews as $key => $review) {
            $reviewsDisplay .= getReviewListView($review);
        }
        if($reviewsDisplay == ""){
            $reviewsDisplay = '<p>No Reviews Found<p>';
        }

        $message = $_GET['message'];

        include '../view/admin.php';
        break;
}