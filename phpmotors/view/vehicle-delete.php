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

?><!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Delete $invMake $invModel"; }?> | PHP Motors</title>
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
            <?php
                    if(isset($message)) {
                        echo $message;
                    }
                ?>
            <h1><?php 
                if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
                    echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
                elseif(isset($invMake) && isset($invModel)) { 
                    echo "Delete $invMake $invModel"; }?></h1>
                <!-- Display feedback message -->
                <p class="alert">Confirm Vehicle Deletion. The delete is permanent.</p>
                <form method="post" action="/CS%20340/phpmotors/vehicles/index.php">

                    <p class="info-note">*All the fields are required.</p>
                    <!-- Get dynamic drop-down list from controller -->
                    <div class="drop-down">
                        <?php echo $classificationList ?>
                    </div>
                    
                    <label for="invMake">Make</label><br>
                    <input type="text" readonly id="invMake" name="invMake" <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?> >
                    <br>
                    <label for="invModel">Model</label><br>
                    <input type="text" readonly id="invModel" name="invModel" <?php if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }  ?>>
                    <br>
                    <label for="invDescription">Description</label><br>
                    <textarea id="invDescription" name="invDescription" rows="2" cols="25" readonly><?php if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
                    <br>
                    <br><br>
                    <button type="submit" name="submit" id="carbtn" value="Delete Vehicle">Delete Vehicle</button>
                    
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="deleteVehicle">
                    <input type="hidden" name="invId" value="<?php if(isset($invId)){ echo $invId; } ?>">
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
