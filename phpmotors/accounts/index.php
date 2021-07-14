<?php
    //This is the accounts contoller
    
    // Create or access a Session
    session_start();

    //Get the database connection file
    require_once "../library/connections.php";
    //Get the PHP Motors model for use as needed
    require_once "../model/main-model.php";
    //Get the accounts model
    require_once "../model/accounts-model.php";
    //Get the reviews model
    require_once "../model/reviews-model.php";
    //Get the vehicles model
    require_once "../model/vehicles-model.php";
    //Get functions library
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
        case 'Login':
            include '../view/login.php';
            break; 
        case 'processLogin':
            // Filter and store the data
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);

            // Check for missing data
            if(empty($clientEmail) || empty($checkPassword)) {
                $message = '<p class="error-notice">Please provide valid information for all the form fields.</p>';
                include '../view/login.php';
                exit; 
            }

            // Check for an existing email
            $existingEmail = checkExistingEmail($clientEmail);

            // Check if account exists within the table using the email address
            if(!$existingEmail){
                $message = "<p class='error-notice'> Sorry, that account $clientEmail do not exist in our system. You can register by </p>";
                $message.="<a class='text-link' href='/CS%20340/phpmotors/accounts/?action=Register'>click here.</a>";
                include '../view/login.php';
                exit;
            }

            // A valid account exists, proceed with the login process
            // Query the client data based on the email address
            $clientData = getClient($clientEmail);

            // Compare the password just submitted against
            // the hashed password for the matching client
            $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
            
            // If the hashes don't match create an error
            // and return to the login view
            if(!$hashCheck) {
            $message = '<p class="error-notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
            }

            // A valid user exists, log them in
            $_SESSION['loggedin'] = TRUE;

            // Remove the password from the array
            // the array_pop function removes the last
            // element from an array
            array_pop($clientData);

            // Store the array into the session
            $_SESSION['clientData'] = $clientData;

            //Generate reviews table
            $clientReviews = getClientReviews($_SESSION['clientData']['clientId']);
            $reviewedCarsNames = [];
            foreach($clientReviews as $review){
                $invId = $review['invId'];
                $vehicleInfo = getInvItemInfo($invId);
                $reviewedCarName = $vehicleInfo['invMake']." ".$vehicleInfo['invModel'];
                $reviewedCarsNames[] = $reviewedCarName; 
            }
            $userReviewsTable = buildUserReviewsTable($clientReviews, $reviewedCarsNames);

            //Allow admin functionalities for clients level 2 or 3
            if($_SESSION['clientData']['clientLevel'] > 1){
                $adminLink = "<h3>Vehicle Management</h3><p>Use this link to manage the inventory</p><a class='text-link' href='/CS%20340/phpmotors/vehicles/'>Vehicle Management</a><br>";
                $adminLink.= "<h3>Vehicle Images Management</h3><p>Use this link to manage the inventory images</p><a class='text-link' href='/CS%20340/phpmotors/uploads/'>Images Management</a><br>";
            }

            // Send them to the admin view
            include '../view/admin.php';
            exit;
        
        case 'Logout':
            //Unset client data
            unset($_SESSION['clientData']);

            //Destoy session
            session_destroy();

            //Return to main controller
            header('Location: /CS%20340/phpmotors/');
            exit;

        case 'Register':
            include '../view/register.php';
            break;
        case 'register':
            // Filter and store the data
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
            $clientEmail = checkEmail($clientEmail);
            $checkPassword = checkPassword($clientPassword);

            // Check for an existing email
            $existingEmail = checkExistingEmail($clientEmail);

            // Check for existing email address in the table
            if($existingEmail){
                $message = "<p class='error-notice'>That email address already exists. Do you want to login instead?</p>";
                include '../view/Login.php';
                exit;
            }

            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
                $message = '<p class="error-notice">Please provide information for all empty form fields.</p>';
                include '../view/register.php';
                exit; 
            }

            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

            //Send the data to the model
            $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
            
            //Check and report the result
            if($regOutcome === 1){
                setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
                $message = "<p class='notice'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";   
                $_SESSION['message'] = $message;
                header('Location: /CS%20340/phpmotors/accounts/?action=Login');
                exit;
            } 
            else {
                $message = "<p class='notice'>Sorry, $clientFirstname, but the registration failed. Please try again.</p>";
                include "../view/register.php";
                exit;
            }
        
        case 'updateClient':
            include "../view/client-update.php";
            break;

        case 'processClientUpdate':
            // Filter and store the data
            $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
            $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
            $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
                $message = '<p class="error-notice">Please provide information for all empty form fields.</p>';
                include '../view/client-update.php';
                exit; 
            }

            //Check for existing email only if the client is trying to change the current email
            $checkNewEmail = checkNewEmail($clientEmail, $clientId);
            if($checkNewEmail){
                // Check for an existing email
                $existingEmail = checkExistingEmail($clientEmail);

                // Check for existing email address in the table
                if($existingEmail){
                    $message = "<p class='error-notice'>That email address is already being used by another account.</p>";
                    include '../view/client-update.php';
                    exit;
                }
            }

            //Send the data to the model
            $updateOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
            
            //Check and report the result
            if($updateOutcome === 1){
                setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
                
                //Update session
                $clientData = getClientData($clientId);

                // Store the array into the session
                $_SESSION['clientData'] = $clientData;

                $message = "<p class='notice'>$clientFirstname, your info has been updated.</p>";   
                $_SESSION['message'] = $message;
                header('Location: /CS%20340/phpmotors/accounts/');
                exit;
            } 
            else {
                $message = "<p class='error-notice'>No information was updated.</p>";   
                $_SESSION['message'] = $message;
                header('Location: /CS%20340/phpmotors/accounts/');
                exit;
            }
            break;

        case 'changeClientPassword':
            // Filter and store the data
            $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
            $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
            $checkPassword = checkPassword($clientPassword);

            // Check for missing data
            if(empty($checkPassword)){
                $passwordMessage = '<p class="error-notice">Please make sure your password matches the requirements.</p>';
                include '../view/client-update.php';
                exit; 
            }

            // Hash the checked password
            $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

            //Send the data to the model
            $changeOutcome = changePassword($hashedPassword, $clientId);
            
            //Check and report the result
            if($changeOutcome === 1){
                $message = "<p class='notice'>Your password has been updated.</p>";   
                $_SESSION['message'] = $message;
                header('Location: /CS%20340/phpmotors/accounts/');
                exit;
            } 
            else {
                $message = "<p class='error-notice'>Error: Password wasn't updated. Please try again.</p>";   
                $_SESSION['message'] = $message;
                header('Location: /CS%20340/phpmotors/accounts/');
                exit;
            }
            break; 

        default:
            //Generate reviews table
            $clientReviews = getClientReviews($_SESSION['clientData']['clientId']);
            $reviewedCarsNames = [];
            foreach($clientReviews as $review){
                $invId = $review['invId'];
                $vehicleInfo = getInvItemInfo($invId);
                $reviewedCarName = $vehicleInfo['invMake']." ".$vehicleInfo['invModel'];
                $reviewedCarsNames[] = $reviewedCarName; 
            }

            $userReviewsTable = buildUserReviewsTable($clientReviews, $reviewedCarsNames);

            //Allow admin functionalities for clients level 2 or 3
            if($_SESSION['clientData']['clientLevel'] > 1){
                $adminLink = "<h3>Vehicle Management</h3><p>Use this link to manage the inventory</p><a class='text-link' href='/CS%20340/phpmotors/vehicles/'>Vehicle Management</a><br>";
                $adminLink.= "<h3>Vehicle Images Management</h3><p>Use this link to manage the inventory images</p><a class='text-link' href='/CS%20340/phpmotors/uploads/'>Images Management</a><br>";
            }

            include "../view/admin.php";
            break;
    }
?>   