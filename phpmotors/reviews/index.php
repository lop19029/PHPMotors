<?php
    //This is the reviews controller

    // Create or access a Session
    session_start();

    //Requirements
    require_once "../library/connections.php";
    require_once "../model/main-model.php";
    require_once "../model/reviews-model.php";
    require_once "../model/vehicles-model.php";
    require_once "../model/uploads-model.php";
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
            $reviewDate = date("Y-m-d H:i:s", strtotime("now"));
            
            //Rebuild view
            $vehicleInfo = getVehicleInfo($invId);
            $invMake = $vehicleInfo['invMake'];
            $invModel = $vehicleInfo['invModel'];
            $thumbImages = getThumbImages($invId);
            $vehicleDetails = buildVehicleDetails($vehicleInfo, $thumbImages);
            $clientId = $_SESSION['clientData']['clientId'];
            $clientFirstname = $_SESSION['clientData']['clientFirstname'];
            $clientLastname = $_SESSION['clientData']['clientLastname'];
            $clientScreenName = generateClientScreenName($clientFirstname, $clientLastname);
            $reviewForm = buildReviewsForm($clientScreenName, $clientId, $invId, $vehicleInfo);

            // Check for missing data
            if(empty($reviewText)) {
                $reviewMessage = "<p class='error-notice'>Please write your review in the blank field below.</p>";
                include '../view/vehicle-detail.php';
                exit; 
            }

            //Send the data to the model
            $insertReviewOutcome = insertReview($reviewText, $reviewDate, $invId, $clientId);

            //Check and report the result
            if($insertReviewOutcome === 1){
                $reviewMessage = "<p class='notice'>Thanks for your review!</p>";
                include '../view/vehicle-detail.php';
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