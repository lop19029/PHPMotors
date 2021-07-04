<?php
//This is the vehicles controller

// Create or access a Session
session_start();

//Get the database connection file
require_once "../library/connections.php";
//Get the PHP Motors model for use as needed
require_once "../model/main-model.php";
//Get the Vehicles model
require_once "../model/vehicles-model.php";
//Get the Uploads model
require_once "../model/uploads-model.php";
//Get functions library
require_once "../library/functions.php";

//Get the array of classifications
$classifications = getClassifications();
//var_dump($classifications);
//    exit;

// Build a navigation bar using the $classifications array
$navList = generateNav($classifications);

$action = filter_input(INPUT_GET, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_POST, 'action');
    }


switch ($action) {
    case 'Classification':
        include '../view/addClassification.php';
        break;
    case 'addClassification':
        // Filter and store the data
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING));
        // Check for missing data
        if(empty($classificationName)){
            $message = '<p>Please enter a new Classification Name.</p>';
            include '../view/addClassification.php';
            exit; 
        }

        //Send the data to the model
        $newClassOutcome = addClassification($classificationName);
        
        //Check and report the result
        if($newClassOutcome === 1){
            header("Location: /CS 340/phpmotors/vehicles/");
            exit;
        } 
        else {
            $message = "<p>Sorry, but the registration of $classificationName failed. Please try again.</p>";
            include '../view/addClassification.php';
            exit;
        }
    case 'Vehicle':
        include '../view/addVehicle.php';
        break;
    case 'addVehicle':
        // Filter and store the data
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));

        // Check for missing data
        if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/addVehicle.php';
            exit; 
        }

        //Send the data to the model
        $regCarOutcome = regCar($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
        
        //Check and report the result
        if($regCarOutcome === 1){
            $message = "<p>Congratulations! Your $invMake $invModel was succesfully registered.</p>";
                $_SESSION['message'] = $message;
                header('location: /CS 340/phpmotors/vehicles/');
                exit;
        } 
        else {
            $message = "<p>Sorry, but the registration of the $invMake $invModel failed. Please try again.</p>";
            include '../view/addVehicle.php';
            exit;
        }
        
    case 'getInventoryItems': 
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId); 
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray); 
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
    break;
    
    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        
        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<p>Please complete all information for the item! Double check the classification of the item.</p>';
            include '../view/vehicle-update.php';
            exit;
        }
    
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        if ($updateResult) {
            $message = "<p class='notice'>Congratulations, the $invMake $invModel was successfully updated.</p>";
                $_SESSION['message'] = $message;
                header('location: /CS 340/phpmotors/vehicles/');
                exit;
        } 
        else {
            $message = "<p class='error-notice'>Error. the $invMake $invModel was not updated.</p>";
            include '../view/vehicle-update.php';
            exit;
            }
        break;
    
    case 'del':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
    
        $deleteResult = deleteItem($invId);
        if ($deleteResult) {
            $message = "<p class='error-notice'>The $invMake $invModel was permanently deleted.</p>";
                $_SESSION['message'] = $message;
                header('location: /CS 340/phpmotors/vehicles/');
                exit;
        } 
        else {
            $message = "<p class='error-notice'>Error: $invMake $invModel was not deleted.</p>";
                $_SESSION['message'] = $message;
                header('location: /CS 340/phpmotors/vehicles/');
                exit;
            }
        break;
    
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);
        if(!count($vehicles)){
            $message = "<p class='error-notice'>Sorry, no $classificationName vehicles could be found.</p>";
        } 
        else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';
        break;
    case 'vehicle-display':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invMake = filter_input(INPUT_GET, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_GET, 'invModel', FILTER_SANITIZE_STRING);

        $vehicleInfo = getVehicleInfo($invId);
        $thumbImages = getThumbImages($invId);

        if(!count($vehicleInfo) || !count($thumbImages)){
            $message = "<p class='error-notice'>Sorry, no info could be found.</p>";
        }
        else {
            $vehicleDetails = buildVehicleDetails($vehicleInfo, $thumbImages);
        }
        include '../view/vehicle-detail.php';
        break;
    default:

        $classificationList = buildClassificationList($classifications);
        include '../view/vehicleManagement.php';
        break;
}
?>