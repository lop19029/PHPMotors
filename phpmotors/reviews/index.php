<?php
    //This is the reviews controller

    // Create or access a Session
    session_start();

    //Requirements
    require_once "../library/connections.php";
    require_once "../model/main-model.php";
    require_once "../library/functions.php";

    //Get the array of classifications
    $classifications = getClassifications();
    
    // Build a navigation bar using the $classifications array
    $navList = generateNav($classifications);
    
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL){
        $action = filter_input(INPUT_POST, 'action');
    }

    switch ($action) {
        case 'addReview':
            
            break;

        case 'displayEditReview':

            break;

        case 'updateReview':

            break;

        case 'displayDeleteReview':

            break;

        case 'deleteReview':

            break;

        default:
            
            break;
            
    }


?>