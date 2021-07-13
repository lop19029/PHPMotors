<?php
    //This is the reviews controller

    // Create or access a Session
    session_start();

    //Requirements
    require_once "../library/connections.php";
    require_once "../model/main-model.php";
    require_once "../model/reviews-model.php";
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
            // Filter and store the data
            $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
            $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
            $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
            
            // Check for missing data
            if(empty($reviewText)) {
                $reviewMessage = "<p class='error-notice'>Please write your review in the blank field below.</p>";
                include '../view/vehicle-detail.php';
                exit; 
            }

            //Send the data to the model
            $addReviewOutcome = insertReview($reviewText, $invId, $clientId);

            //Check and report the result
            if($addReviewOutcome === 1){
                $reviewMessage = "<p class='notice'>Thanks for your review!</p>";
                header('location: /CS 340/phpmotors/view/vehicle-detail.php');
                exit;
            } 
            else {
                $reviewMessage = "<p class='error-notice' >Sorry, we couldn't upload your review. Please try again</p>";
                include '../view/vehicle-detail.php';
                exit;
            }

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