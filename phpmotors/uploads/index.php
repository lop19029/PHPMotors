<?php
//This is the image upload controller
session_start();

//Requirements
require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../model/uploads-model.php';
require_once '../library/functions.php';

// Get the array of classifications
$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navList = generateNav($classifications);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
 $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

/* * ****************************************************
* Variables for use with the Image Upload Functionality
* **************************************************** */
// directory name where uploaded images are stored
$image_dir = '/phpmotors/uploads/images';
// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

switch ($action) {
    case 'upload':
        // Store the incoming vehicle id and primary picture indicator
        $invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT);
        $imgPrimary = filter_input(INPUT_POST, 'imgPrimary', FILTER_VALIDATE_INT);
	
        // Store the name of the uploaded image
        $imgName = $_FILES['file1']['name'];
            
        $imageCheck = checkExistingImage($imgName);
            
        if($imageCheck){
        $message = '<p class="notice">An image by that name already exists.</p>';
        } elseif (empty($invId) || empty($imgName)) {
        $message = '<p class="notice">You must select a vehicle and image file for the vehicle.</p>';
        } else {
        // Upload the image, store the returned path to the file
        $imgPath = uploadFile('file1');
            
        // Insert the image information to the database, get the result
        $result = storeImages($imgPath, $invId, $imgName, $imgPrimary);
            
        // Set a message based on the insert result
        if ($result) {
        $message = '<p class="notice">The upload succeeded.</p>';
        } else {
        $message = '<p class="notice">Sorry, the upload failed.</p>';
        }
        }
            
        // Store message to session
        $_SESSION['message'] = $message;
            
        // Redirect to this controller for default action
        header('location: .');
        break;
    case 'delete':
    
        break;
    default:

        break;
}