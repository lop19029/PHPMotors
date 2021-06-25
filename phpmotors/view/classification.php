<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
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
                <div><h1><?php echo $classificationName; ?> vehicles</h1>
</div> 
                <?php
                    //Check and display messages if exist
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    } 
                    elseif (isset($message)) { 
                    echo $message; 
                    }
                    
                    //Display cars from classification
                    if(isset($vehicleDisplay)){
                        echo $vehicleDisplay;
                    } 
                    ?>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']); ?>