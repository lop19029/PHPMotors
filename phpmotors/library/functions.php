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
    $dv .= "<a href='/CS%20340/phpmotors/vehicles/?action=vehicle-display&invId=".urlencode($vehicle['invId'])."&invMake=".urlencode($vehicle['invMake'])."&invModel=".urlencode($vehicle['invModel']);
    //Pass client info if logged in
    if(isset($_SESSION['loggedin'])){
        $dv.= "&clientId=".urlencode($_SESSION['clientData']['clientId']);
        $dv.= "&clientFirstname=".urlencode($_SESSION['clientData']['clientFirstname']);
        $dv.= "&clientLastname=".urlencode($_SESSION['clientData']['clientLastname']);
    }
    $dv.= "'><img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a></div>";
    $dv .= "<div class = 'inv-display-info-wrapper'>";
    $dv .= "<a class='text-link' href='/CS%20340/phpmotors/vehicles/?action=vehicle-display&invId=".urlencode($vehicle['invId'])."&invMake=".urlencode($vehicle['invMake'])."&invModel=".urlencode($vehicle['invModel']);
    
    //Pass client info if logged in
    if(isset($_SESSION['loggedin'])){
        $dv.= "&clientId=".urlencode($_SESSION['clientData']['clientId']);
        $dv.= "&clientFirstname=".urlencode($_SESSION['clientData']['clientFirstname']);
        $dv.= "&clientLastname=".urlencode($_SESSION['clientData']['clientLastname']);
    }
    
    $dv.= "'><h2>$vehicle[invMake] $vehicle[invModel]</h2></a>";
    $dv .= "<span>$".number_format($vehicle['invPrice'])."</span></div>";
    $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildVehicleDetails($vehicleInfo, $thumbImages){
    $dv = "<div class='vehicle-display-wrapper'>";
    
    $dv .= "<div class='display-image'>";
    $dv .= "<img src='$vehicleInfo[imgPath]' alt='Image of $vehicleInfo[invMake] $vehicleInfo[invModel] on phpmotors.com'>";
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

    $dv .= "<div class='display-thumbs-wrapper'>";
    $dv .= "<h3 id = 'thumbsTitle'> More Images </h3>";
    $dv .= '<ul class="display-thumbs">';
    foreach ($thumbImages as $thumbImage){
    $dv .= "<li>";
    $dv.= "<img src='$thumbImage[imgPath]' alt='Thumbnail image of $vehicleInfo[invMake] $vehicleInfo[invModel] on phpmotors.com'>";
    $dv .= '</li>';
    }
    $dv .= "</ul>";
    $dv .= "</div>";
    
    $dv .= "</div>";


    return $dv;
}

function buildReviewsForm($clientScreenName, $clientId, $invId, $vehicleInfo){
    $rf = "<div class='review-form-wrapper'>";
    $rf.= "<form action='/CS%20340/phpmotors/reviews/' method='post'>";
    $rf.= "<h3>Write a review for the $vehicleInfo[invMake] $vehicleInfo[invModel]</h3>";
    $rf.= "<label for='clientScreenName'>Screen Name:</label><br>";
    $rf.= "<input id ='clientScreenName' type='text' name='clientScreenName' value='$clientScreenName' readonly><br><br>";
    $rf.= "<label for='reviewText'>Review:</label><br>";
    $rf.= "<textarea id='reviewText' name='reviewText' required></textarea><br>";
    $rf.= "<input type='submit' class='regbtn' value='Submit Review'>";

    //Hidden inputs
    $rf.= "<input type='hidden' name='invId' value='$invId'>";
    $rf.= "<input type='hidden' name='clientId' value='$clientId'>";
    $rf.= "<input type='hidden' name='action' value='addReview'>";

    $rf.= "</form>";
    $rf.= "</div>";

    return $rf;
}

function generateClientScreenName($clientFirstname, $clientLastname){
    //First letter of the First name
    $firstNameInicial = substr($clientFirstname,0,1);

    //Get the first last name in case of multiple last names
    $lastName = $clientLastname;
    $arr = explode(' ', trim($lastName));

    if (isset($arr[0])){
        $firstLastName = $arr[0];
    }
    $lastNameTreated = ucfirst(strtolower($firstLastName));
    
    return $clientScreenName = $firstNameInicial.$lastNameTreated;
}

function buildVehicleReviews($reviewsArr, $writersScreenNames) {
    if(count($reviewsArr) == 0){
        $vr = "<div class='review-display-wrapper'><p id='no-reviews-text'>Be the first to review this vehicle.<p></div>";
        return $vr;
    } 
    $vr = "<div class='review-display-wrapper'>";
    $vr.= "<div class='reviews-display'>";
    $counter = 0;
    foreach($reviewsArr as $review){
        $vr.= "<div class = 'review-wrapper'>";
        $vr.= "<p>$writersScreenNames[$counter] wrote on ";
        $vr.= date("d M, Y", strtotime($review['reviewDate']));
        $vr.= ":</p><br>";
        $vr.= "<textarea id='reviewText' name='reviewText' readonly>$review[reviewText]</textarea>";
        $vr.= "</div><br>";
        $counter++;
    }
    $vr.= "</div></div>";
    return $vr;
}

function buildUserReviewsTable($clientReviews, $reviewedCarsNames){
    $rt = '<table><thead>';
    $rt.= '<tr><th>Vehicle Name</th><th>Review</th><td>&nbsp;</td><td>&nbsp;</td></tr>'; 
    $rt.= '</thead><tbody>';
    $counter = 0;
    foreach($clientReviews as $review){
        $rt.="<tr><td>$reviewedCarsNames[$counter]</td>";
        $rt.="<td>$review[reviewText]</td>";
        $rt.= "<td><a class='modify-link' href='/CS%20340/phpmotors/reviews?action=displayEditReview&reviewId=$review[reviewId]&invId=$review[invId]' title='Click to modify'>Modify</a></td>";
        $rt.= "<td><a class='delete-link' href='/CS%20340/phpmotors/reviews?action=displayDeleteReview&reviewId=$review[reviewId]&invId=$review[invId]' title='Click to delete'>Delete</a></td></tr>";
        $counter++;
    }
    $rt.= '</tbody></table>';
    return $rt;
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
     $id .= "<p><a class='text-link' href='/CS%20340/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
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
        return false;
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

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
   
    // Set up the image path
    $image_path = $dir . $filename;
   
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}


// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    } // ends the swith
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);
    
        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);
    
        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
        $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
        imagecolortransparent($new_image, $alpha);
        }
    
        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
        }
    
        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
    
        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
    } else {
     // Write the old image to a new file
     $image_to_file($old_image, $new_image_path);
    }
     // Free any memory associated with the old image
     imagedestroy($old_image);

} // ends resizeImage function

?>