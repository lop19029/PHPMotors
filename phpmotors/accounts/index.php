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
                $message = '<p>Please provide valid information for all the form fields.</p>';
                include '../view/login.php';
                exit; 
            }

            // Check for an existing email
            $existingEmail = checkExistingEmail($clientEmail);

            // Check if account exists within the table using the email address
            if(!$existingEmail){
                $message = "<p class='notice'> Sorry, that account $clientEmail do not exist in our system. You can register by </p>";
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
            $message = '<p class="notice">Please check your password and try again.</p>';
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

            //Allow admin functionalities for clients level 2 or 3
            if($_SESSION['clientData']['clientLevel'] > 1){
                $adminLink = "<a class='text-link' href='/CS%20340/phpmotors/vehicles/'>Vehicle Management.</a>";
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
                $message = "<p class='notice'>That email address already exists. Do you want to login instead?</p>";
                include '../view/Login.php';
                exit;
            }

            // Check for missing data
            if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
                $message = '<p>Please provide information for all empty form fields.</p>';
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
                $message = "Thanks for registering $clientFirstname. Please use your email and password to login.";   
                $_SESSION['message'] = $message;
                header('Location: /CS%20340/phpmotors/accounts/?action=Login');
                exit;
            } 
            else {
                $message = "<p>Sorry, $clientFirstname, but the registration failed. Please try again.</p>";
                include "../view/register.php";
                exit;
            }
        
        case 'updateClient':
            break;
        default:
            //Allow admin functionalities for clients level 2 or 3
            if($_SESSION['clientData']['clientLevel'] > 1){
                $adminLink = "<a class='text-link' href='/CS%20340/phpmotors/vehicles/'>Vehicle Management.</a>";
            }

            include "../view/admin.php";
            break;
    }
?>   