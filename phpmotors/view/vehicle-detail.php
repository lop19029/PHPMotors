<?php
//Check if the user has logged in
if(!isset($_SESSION['loggedin'])){
    unset ($reviewForm);
    $loginToReview = "<p>You must <a class='text-link' href='/CS%20340/phpmotors/accounts/?action=Login'>login</a> to write a review.";
}


?><!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title><?php echo $invMake." ".$invModel." Details"; ?> | PHP Motors, Inc.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen">
        <link rel="stylesheet" type="text/css" href="../css/display-styles.css" media="screen">
    </head>
    <body>
        <div class = "page-wrapper">
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/header.php'; ?> 
            <nav class="nav-bar"> 
                <?php echo $navList;?>
            </nav>
            <main>
                <div><h1><?php echo $invMake." ".$invModel; ?></h1></div> 
                <?php
                    //Check and display messages if exist
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    } 
                    elseif (isset($message)) { 
                    echo $message; 
                    }
                    
                    //Display cars from classification
                    if(isset($vehicleDetails)){
                        echo $vehicleDetails;
                    } 
                ?>
                <div class="reviews-wrapper">
                    <h2>Customer reviews</h2>
                    <?php
                        if(isset($reviewMessage)){
                            echo $reviewMessage;
                        } ?>
                    
                    <div class="reviews-form-wrapper">
                        <?php
                            //Display reviews form for logged clients
                            if(isset($reviewForm)){
                                echo $reviewForm;
                            }
                            else {
                                echo $loginToReview;
                            }
                        ?>
                    </div>
                    <div class="reviews-content-wrapper">
                        <?php
                            //Display reviews section for this car
                            echo $vehicleReviews;
                        ?>
                    </div>
                </div>


            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']); ?>