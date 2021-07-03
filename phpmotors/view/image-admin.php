<?php

//Catch SESSION messages
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?><!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Image Management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen">
        <link rel="stylesheet" type="text/css" href="../css/upload-styles.css" media="screen">
    </head>
    <body>
        <div class = "page-wrapper">
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/header.php'; ?> 
            <nav class="nav-bar"> 
                <?php echo $navList;?>
            </nav>
            <main>
                <h1>Image Management</h1>
                <p>Welcome! Please choose one of the options below.</p>
                <h2>Add New Vehicle Image</h2>
                <?php
                    if (isset($message)) {
                        echo $message;
                    } 
                ?>

                <form action="/CS%20340/phpmotors/uploads/" method="post" enctype="multipart/form-data">
                    <label for="invItem">Vehicle</label>
                    <?php echo $prodSelect; ?>
                    <fieldset>
                        <label>Is this the main image for the vehicle?</label>
                        <label for="priYes" class="pImage">Yes</label>
                        <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
                        <label for="priNo" class="pImage">No</label>
                        <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
                    </fieldset>
                    <label>Upload Image:</label>
                    <input type="file" name="file1">
                    <input type="submit" class="regbtn" value="Upload">
                    <input type="hidden" name="action" value="upload">
                </form>
                <hr>
                <h2>Existing Images</h2>
                <p>If deleting an image, delete the thumbnail too and vice versa.</p>
                <?php
                    if (isset($imageDisplay)) {
                        echo $imageDisplay;
                    } 
                ?>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']); ?>
