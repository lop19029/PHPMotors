<?php
//This is the vehicles controller

//Get the database connection file
require_once "../library/connections.php";
//Get the PHP Motors model for use as needed
require_once "../model/main-model.php";
//Get the Vehicles model
require_once "../model/vehicles-model.php";

//Get the array of classifications
$classifications = getClassifications();
//var_dump($classifications);
//    exit;

// Build a navigation bar using the $classifications array
$navList = "<ul>";
$navList.= "<li><a href='/CS%20340/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
    $navList .= "<li><a href='/CS%20340/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList.= "</ul>";

// Build a drop down select list using the $classifications array
$classificationList = "<label for='classificationId'>Choose Car Classification</label><br>";
$classificationList.= "<select id='classificationId' name='classificationId'>";
foreach ($classifications as $classification) {
   $classificationList.= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
}
$classificationList.= "</select>";


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
        $classificationName = filter_input(INPUT_POST, 'classificationName');

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
            include '../view/addVehicle.php';
            exit;
        } 
        else {
            $message = "<p>Sorry, but the registration of the $invMake $invModel failed. Please try again.</p>";
            include '../view/addVehicle.php';
            exit;
        }
    default:
        include '../view/vehicleManagement.php';
        break;
}
?>