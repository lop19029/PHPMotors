<?php
    //This is the accounts contoller

    //Get the database connection file
    require_once "../library/connections.php";
    //Get the PHP Motors model for use as needed
    require_once "../model/main-model.php";
    //Get the accounts model
    require_once "../model/accounts-model.php";

    //Get the array of classifications
    $classifications = getClassifications();
    
    // Build a navigation bar using the $classifications array
    $navList = "<ul>";
    $navList.= "<li><a href='/CS%20340/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/CS%20340/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList.= "</ul>";
    
    
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_POST, 'action');
    }

    switch ($action) {
        case 'Login':
            include '../view/login.php';
            break;
        case 'Register':
            include '../view/register.php';
            break;
        case 'register';
            // Filter and store the data
            $clientFirstname = filter_input(INPUT_POST, 'clientFirstname');
            $clientLastname = filter_input(INPUT_POST, 'clientLastname');
            $clientEmail = filter_input(INPUT_POST, 'clientEmail');
            $clientPassword = filter_input(INPUT_POST, 'clientPassword');

            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientPassword)){
                $message = '<p>Please provide information for all empty form fields.</p>';
                include '../view/register.php';
                exit; 
            }
            break;
        default:
            break;
    }
?>   