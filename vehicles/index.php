<?php
// this is the vehicles controller for the site

// Get the database connection file
require_once '../library/connections.php';
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/vehicles-model.php';
// Get the functions library
require_once '../library/functions.php';

$classifications = getClassifications();
$navList = buildNav($classifications);

$classificationList = '<label for="classificationId">Choose a Vehicle Classification:</label>';
$classificationList .= '<select name="classificationId" id="classificationId">';
foreach ($classifications as $classification) {
    $classificationList .= "<option value=".urlencode($classification['classificationId']).">".urlencode($classification['classificationName'])."</option>";
}
$classificationList .= '</select>';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action){
    case 'classification':
        include '../view/add-classification.php';
        break;
    case 'vehicle':
        include '../view/add-vehicle.php';
        break;
    case 'add-classification':
        // Filter and store the data
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING));
        $verifiedClassificationName = checkclassificationName($classificationName);
        // Check for missing data
        if(empty($verifiedClassificationName)){
            $message = '<p class="vehicle-title">Please provide information for all empty form fields.</p>';
            include '../view/add-classification.php';
            exit; 
        }

        $classificationOutcome = insertClassification($classificationName);

        // Check and report the result
        if($classificationOutcome === 1){
            header('Location: index.php');
            exit;
        } else {
            $message = '<p class="vehicle-title">Sorry but the addition failed. Please try again.</p>';
            include '../view/add-classification.php';
            exit;
        }

        break;
    case 'add-vehicle':
        // Filter and store the data
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_FLOAT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_FLOAT));
        // Check for missing data
        if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)){
            $message = '<p class="vehicle-title">Please provide information for all empty form fields.</p>';
            include '../view/add-vehicle.php';
            exit; 
        }

        $vehicleOutcome = insertVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

        // Check and report the result
        if($vehicleOutcome === 1){
            $message = '<p class="vehicle-title">Vehicle Added!</p>';
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = '<p class="vehicle-title">Sorry but the addition failed. Please try again.</p>';
            include '../view/add-vehicle.php';
            exit;
        }

        
        break;
    default:
        include '../view/vehicle-man.php';
        break;
}