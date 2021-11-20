<?php
// this is the vehicles controller for the site

// Create or access a Session
session_start();

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
    case 'class':
        include '../view/add-classification.php';
        break;
    case 'vehicle':
        include '../view/add-vehicle.php';
        break;
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);
        if(!count($vehicles)){
            $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';
        break;
    case 'viewVehicle':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_STRING);
        // request DB
        $vehicle = getInvItemInfo($invId);
        if(!count($vehicle)){
            $message = "<p class='notice'>Sorry, vehicle could not be found.</p>";
        } else {
            $vehicleDetails = buildVehicleInfo($vehicle);
        }
        // build html view, accessible from vehicle-detail.php
        $pageTitle = $vehicle['invMake'] . ' ' . $vehicle['invModel'] . ' details';
        include '../view/vehicle-detail.php';
        break;
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);
        if(!count($vehicles)){
            $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';
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
    case 'getInventoryItems': 
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId); 
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray); 
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
        $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
                $message = 'Sorry, no vehicle information could be found.';
            }
            include '../view/vehicle-delete.php';
            exit;
            break;

    case 'updateVehicle':
        // Filter and store the data
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
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
            include '../view/vehicle-update.php';
            exit; 
        }

        $updateResult = updateVehicle($invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

        // Check and report the result
        if ($updateResult) {
            $message = "<p class='vehicle-title'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = '<p class="vehicle-title">Sorry but the update failed. Please try again.</p>';
            include '../view/vehicle-update.php';
            exit;
        }

        
        break;

    case 'deleteVehicle':
		// Filter and store the data
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        

        $deleteResult = deleteVehicle($invId);

        // Check and report the result
        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invMake $invModel was not
        deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;
            
    default:
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicle-man.php';
        exit;
        break;
}