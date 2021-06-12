<?php
    //This is the main controller

    //Get the database connection file
    require_once "library/connections.php";
    //Get the PHP Motors model for use as needed
    require_once "model/main-model.php";
    //Get functions library
    require_once "library/functions.php";

    //Get the array of classifications
    $classifications = getClassifications();
    //var_dump($classifications);
    //    exit;

    // Build a navigation bar using the $classifications array
    $navList = generateNav($classifications);

    $action = filter_input(INPUT_POST, 'action');
    if ($action = NULL){
        $action = filter_input(INPUT_GET, 'action');
    }
    
    // Check if the firstname cookie exists, get its value
    if(isset($_COOKIE['firstname'])){
        $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
    }
    
    switch ($action) {
        case 'template':
            include 'template.php';
            break;
        default:
            include 'model/home.php';
    }
?>   