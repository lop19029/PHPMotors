<?php

//Check if the user has logged in
if(!$_SESSION['loggedin']){
    header('Location: /CS%20340/phpmotors/');
    exit;
}

?><!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Delete Review</title>
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
                
                <div><h1>Manage Review</h1></div>
                <?php if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    } 
                ?>
                <form method="post" action="/CS%20340/phpmotors/reviews/">
                    <h2>Delete review for <?php echo $vehicleInfo['invMake'], " ", $vehicleInfo['invModel'];?></h2>
                    <p>Originally posted on <?php echo date("d M, Y", strtotime($reviewInfo[0]['reviewDate']));?></p><br>
                    <label for='reviewText'>Review:</label><br>
                    <textarea id='reviewText' name='reviewText' readonly><?php if(isset($reviewInfo)){echo $reviewInfo[0]['reviewText'];}?></textarea><br>
                    <br><br>
                    <p class="info-note">*Warning: The deletition process is permanent.</p>
                    <button type="submit" name="submit" value="Delete Review">Delete Review</button>
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="deleteReview">
                    <input type="hidden" name="reviewId" value="<?php if(isset($reviewInfo)){ echo $reviewInfo[0]['reviewId']; } ?>">
                    <input type="hidden" name="invId" value="<?php if(isset($vehicleInfo)){ echo $vehicleInfo['invId']; } ?>">

                    <br>
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']); ?>