<?php
    //This is the reviews controller

    // Create or access a Session
    session_start();

    //Requirements
    require_once "../library/connections.php";
    require_once "../model/main-model.php";
    require_once "../model/accounts-model.php";
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
            
            // Check for missing data
            if(empty($reviewText)) {
                $reviewMessage = "<p class='error-notice'>Sorry, you can't submit an empty review.</p>";
                $_SESSION['message'] = $reviewMessage;
                header("location: /CS 340/phpmotors/reviews/?invId=$invId");
                exit; 
            }

            //Send the data to the model
            $insertReviewOutcome = insertReview($reviewText, $reviewDate, $invId, $clientId);

            //Check and report the result
            if($insertReviewOutcome === 1){
                $reviewMessage = "<p class='notice'>Thanks for your review!</p>";
                $_SESSION['message'] = $reviewMessage;
                header("location: /CS 340/phpmotors/reviews/?invId=$invId");
                exit;
            } 
            else {
                $reviewMessage = "<p class='error-notice' >Sorry, we couldn't upload your review. Please try again</p>";
                $_SESSION['message'] = $reviewMessage;
                header("location: /CS 340/phpmotors/reviews/?invId=$invId");
                exit;
            }

            break;

        case 'displayEditReview':
            $reviewId = trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
            $invId=trim(filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT));

            //Get review info from model
            $reviewInfo = getReviewById($reviewId);
            //Get vehicles info
            $vehicleInfo = getInvItemInfo($invId);

            include '../view/review-update.php';
            break;

        case 'updateReview':
            $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
            $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING)); 
            $invId=trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));

            // Check for missing data
            if(empty($reviewText)) {
                $reviewMessage = "<p class='error-notice'>Sorry, you can't submit an empty review.</p>";
                $_SESSION['message'] = $reviewMessage;
                header("location: /CS 340/phpmotors/reviews/?action=displayEditReview&reviewId=$reviewId&invId=$invId");
                exit;
            }

            //Ask model to update the review
            $updateReviewOutcome = updateReviewById($reviewId, $reviewText);
            
            //Check and report the result
            if($updateReviewOutcome === 1){
                $reviewMessage = "<p class='notice'>Your review was succesfully updated.</p>";
                $_SESSION['message'] = $reviewMessage;
                header("location: /CS 340/phpmotors/accounts/");
                exit;
            } 
            else {
                $reviewMessage = "<p class='error-notice' >Sorry, we couldn't update your review. Please try again</p>";
                $_SESSION['message'] = $reviewMessage;
                header("location: /CS 340/phpmotors/accounts/");
                exit;
            }

            break;

        case 'displayDeleteReview':
            $reviewId = trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
            $invId=trim(filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT));

            //Get review info from model
            $reviewInfo = getReviewById($reviewId);
            //Get vehicles info
            $vehicleInfo = getInvItemInfo($invId);
            include '../view/review-delete.php';
            break;

        case 'deleteReview':
            $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));

            //Ask model to update the review
            $deleteReviewOutcome = deleteReviewById($reviewId);
            
            //Check and report the result
            if($deleteReviewOutcome === 1){
                $reviewMessage = "<p class='notice'>Your review was succesfully deleted.</p>";
                $_SESSION['message'] = $reviewMessage;
                header("location: /CS 340/phpmotors/accounts/");
                exit;
            } 
            else {
                $reviewMessage = "<p class='error-notice' >Sorry, we couldn't delete your review. Please try again</p>";
                $_SESSION['message'] = $reviewMessage;
                header("location: /CS 340/phpmotors/accounts/");
                exit;
            }
            break;

        default:
            $invId = trim(filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT));
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
            //Generate reviews display for this vehicle
            $reviewsArr = getInvReviews($invId);
            $writersScreenNames = [];
            foreach($reviewsArr as $review){
                $clientId = $review['clientId'];
                $clientInfo = getClientData($clientId);
                $clientFirstname = $clientInfo['clientFirstname'];
                $clientLastname = $clientInfo['clientLastname'];
                $clientScreenName = generateClientScreenName($clientFirstname, $clientLastname);
                $writersScreenNames[] = $clientScreenName;
            }

            $vehicleReviews = buildVehicleReviews($reviewsArr, $writersScreenNames); 
            include '../view/vehicle-detail.php';
            break;

    }


?>