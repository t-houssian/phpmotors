<?php
// this is the vehicles controller for the site

// Get the database connection file
require_once '../library/connections.php';
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/vehicles-model.php';

$classifications = getClassifications();
$count = count($classifications) + 1;

$navList = "<ul style='grid-template-columns: repeat($count, auto);'>";
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
    $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';

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
        $classificationName = filter_input(INPUT_POST, 'classificationName');
        // Check for missing data
        if(empty($classificationName)){
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
        $invMake = filter_input(INPUT_POST, 'invMake');
        $invModel = filter_input(INPUT_POST, 'invModel');
        $invDescription = filter_input(INPUT_POST, 'invDescription');
        $invImage = filter_input(INPUT_POST, 'invImage');
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
        $invPrice = filter_input(INPUT_POST, 'invPrice');
        $invStock = filter_input(INPUT_POST, 'invStock');
        $invColor = filter_input(INPUT_POST, 'invColor');
        $classificationId = filter_input(INPUT_POST, 'classificationId');
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