<?php
//Check if the user has logged in
if(!$_SESSION['loggedin']){
    header('Location: /CS%20340/phpmotors/');
    exit;
}
//Check the user level
elseif(isset($_SESSION['loggedin'])){
    if($_SESSION['clientData']['clientLevel'] < 2){
        header('Location: /CS%20340/phpmotors/');
        exit;
    }
}

// Build the classifications option list
$classifList = '<select name="classificationId" id="classificationId">';
$classifList .= "<option>Choose a Car Classification</option>";
foreach ($carClassifications as $classification) {
 $classifList .= "<option value='$classification[classificationId]'";
 if(isset($classificationId)){
  if($classification['classificationId'] === $classificationId){
   $classifList .= ' selected ';
  }
 } 
 elseif(isset($invInfo['classificationId'])){
 if($classification['classificationId'] === $invInfo['classificationId']){
  $classifList .= ' selected ';
 }
}
$classifList .= ">$classification[classificationName]</option>";
}
$classifList .= '</select>';
?><!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?> | PHP Motors</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen">
        <link rel="stylesheet" type="text/css" href="../css/form-styles.css" media="screen">
    </head>
    <body>
        <div class = "page-wrapper">
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/header.php'; ?> 
                <nav class="nav-bar"> 
                    <?php echo $navList;?>
                </nav>
            <main>
            <h1><?php 
                if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
                    echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
                elseif(isset($invMake) && isset($invModel)) { 
                    echo "Modify$invMake $invModel"; }?></h1>
                <!-- Display feedback message -->
                <?php
                    if(isset($message)) {
                        echo $message;
                    }
                ?>
                <form method="post" action="/CS%20340/phpmotors/vehicles/index.php">

                    <p class="info-note">*All the fields are required.</p>
                    <!-- Get dynamic drop-down list from controller -->
                    <div class="drop-down">
                        <?php echo $classificationList ?>
                    </div>
                    
                    <label for="invMake">Make</label><br>
                    <input type="text" placeholder="Mercedes-Benz" id="invMake" name="invMake" <?php if(isset($invMake)){echo "value='$invMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?> required>
                    <br>
                    <label for="invModel">Model</label><br>
                    <input type="text" placeholder="C 180" id="invModel" name="invModel" <?php if(isset($invModel)){echo "value='$invModel'";} elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }  ?> required>
                    <br>
                    <label for="invDescription">Description</label><br>
                    <textarea id="invDescription" name="invDescription" rows="2" cols="25" required><?php if(isset($invDescription)){echo"$invDescription";} elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
                    <br>
                    <label for="invImage">Image Path</label><br>
                    <input type="text" id="invImage" name="invImage" value="/CS 340/phpmotors/images/no-image.png" <?php if(isset($invImage)){echo "value='$invImage'";} elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; }  ?> required>
                    <br>
                    <label for="invThumbnail">Thumbnail Path</label><br>
                    <input type="text" id="invThumbnail" name="invThumbnail" value="/CS 340/phpmotors/images/no-image-tn.png" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; }  ?> required>
                    <br>
                    <label for="invPrice">Price</label><br>
                    <input type="number" placeholder="100000" id="invPrice" name="invPrice" <?php if(isset($invPrice)){echo "value='$invPrice'";} elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; }  ?> required>
                    <br>
                    <label for="invStock">Stock</label><br>
                    <input type="number" placeholder="5" id="invStock" name="invStock" <?php if(isset($invStock)){echo "value='$invStock'";} elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; }  ?> required>
                    <br>
                    <label for="invColor">Color</label><br>
                    <input type="text" placeholder="Black" id="invColor" name="invColor" <?php if(isset($invColor)){echo "value='$invColor'";} elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }  ?> required>
                    <br><br>
                    <button type="submit" name="submit" id="carbtn" value="Update Vehicle">Modify Vehicle</button>
                    
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="updateVehicle">
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
