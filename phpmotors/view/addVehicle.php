<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Add Vehicle</title>
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
                <h1>Add Vehicle</h1>
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
                    <input type="text" placeholder="Mercedes-Benz" id="invMake" name="invMake">
                    <br>
                    <label for="invModel">Model</label><br>
                    <input type="text" placeholder="C 180" id="invModel" name="invModel">
                    <br>
                    <label for="invDescription">Description</label><br>
                    <textarea id="invDescription" name="invDescription" rows="2" cols="25"></textarea>
                    <br>
                    <label for="invImage">Image Path</label><br>
                    <input type="text" id="invImage" name="invImage" value="/CS 340/phpmotors/images/no-image.png">
                    <br>
                    <label for="invThumbnail">Thumbnail Path</label><br>
                    <input type="text" id="invThumbnail" name="invThumbnail" value="/CS 340/phpmotors/images/no-image-tn.png">
                    <br>
                    <label for="invPrice">Price</label><br>
                    <input type="text" placeholder="100000" id="invPrice" name="invPrice" maxlength="20">
                    <br>
                    <label for="invStock">Stock</label><br>
                    <input type="text" placeholder="5" id="invStock" name="invStock" maxlength="10">
                    <br>
                    <label for="invColor">Color</label><br>
                    <input type="text" placeholder="Black" id="invColor" name="invColor">
                    <br><br>
                    <button type="submit" name="submit" id="carbtn" value="Add Vehicle">Add Vehicle</button>
                    
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="addVehicle">
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
