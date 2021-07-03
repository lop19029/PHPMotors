<?php

function checkEmail($clientEmail){
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

function checkPassword($clientPassword) {
    // Check the password for a minimum of 8 characters,
    // at least one 1 capital letter, at least 1 number and
    // at least 1 special character
        $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
        return preg_match($pattern, $clientPassword);
    
}

function generateNav($classifications) {
    $navList = "<ul>";
    $navList.= "<li><a href='/CS%20340/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/CS%20340/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList.= "</ul>";
    return $navList;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) { 
     $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    $classificationList .= '</select>'; 
    return $classificationList; 
   }

   
function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
    $dv .= "<li>";
    $dv .= "<div class = 'inv-display-image-wrapper'>";
    $dv .= "<a href='/CS%20340/phpmotors/vehicles/?action=vehicle-display&invId=".urlencode($vehicle['invId'])."&invMake=".urlencode($vehicle['invMake'])."&invModel=".urlencode($vehicle['invModel'])."'><img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a></div>";
    $dv .= "<div class = 'inv-display-info-wrapper'>";
    $dv .= "<a class='text-link' href='/CS%20340/phpmotors/vehicles/?action=vehicle-display&invId=".urlencode($vehicle['invId'])."&invMake=".urlencode($vehicle['invMake'])."&invModel=".urlencode($vehicle['invModel'])."'><h2>$vehicle[invMake] $vehicle[invModel]</h2></a>";
    $dv .= "<span>$".number_format($vehicle['invPrice'])."</span></div>";
    $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildVehicleDetails($vehicleInfo){
    $dv = "<div class='vehicle-display-wrapper'>";

    $dv .= "<div class='display-image'>";
    $dv .= "<img src='$vehicleInfo[invImage]' alt='Image of $vehicleInfo[invMake] $vehicleInfo[invModel] on phpmotors.com'>";
    $dv .= "</div>";

    $dv .= "<div class='display-details-wrapper'>";

    $dv .= "<div class='display-title'>";
    $dv .= "<h2>$vehicleInfo[invMake] $vehicleInfo[invModel] Details</h2>";
    $dv .= "</div>";
    $dv .= "<div class='display-description'>";
    $dv .= "<p>$vehicleInfo[invDescription]</p>";
    $dv .= "</div>";
    $dv .= "<div class='display-color'>";
    $dv .= "<p>Color: $vehicleInfo[invColor]</p>";
    $dv .= "</div>";
    $dv .= "<div class='display-stock'>";
    $dv .= "<p>Available: $vehicleInfo[invStock]</p>";
    $dv .= "</div>";
    $dv .= "<div class='display-price'>";
    $dv .= "<p>Price: $".number_format($vehicleInfo['invPrice'])."</p>";
    $dv .= "</div>";

    $dv .= "</div>";

    $dv .= "</div>";

    return $dv;
}

/* * ********************************
*  Functions for working with images
* ********************************* */
// Adds "-tn" designation to file name
function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
     $id .= "<p><a href='/CS%20340/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
     $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}

// Build the vehicles select list
function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
     $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
        return;
        }
        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;
        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);
        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        // Returns the path where the file is stored
        return $filepath;
    }
}
?>