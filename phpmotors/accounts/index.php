<?php
    //This is the accounts contoller

    //Get the database connection file
    require_once "../library/connections.php";
    //Get the PHP Motors model for use as needed
    require_once "../model/main-model.php";

    //Get the array of classifications
    $classifications = getClassifications();
    
    // Build a navigation bar using the $classifications array
    $navList = "<ul>";
    $navList.= "<li><a href='/CS%20340/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/CS%20340/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList.= "</ul>";
    
    
    //$action = filter_input(INPUT_POST, 'action');
    //if ($action = NULL){
    //    $action = filter_input(INPUT_GET, 'action');
    //}
    $action = filter_input(INPUT_GET, 'action');

    switch ($action) {
        case 'Login':
            include '../view/login.php';
            break;
        case 'Register':
            include '../view/register.php';
            break;
        default:
            break;
    }
?>   