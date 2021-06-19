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
        <title>PHP Motors - Vehicles Managemente</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen">
    </head>
    <body>
        <div class = "page-wrapper">
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/header.php'; ?> 
                <nav class="nav-bar"> 
                    <?php echo $navList;?>
                </nav>
            <main>
                <h1>Vehicle Managment</h1>
                <ul>
                    <li><a href="/CS%20340/phpmotors/vehicles/?action=Classification">Add a new Classification</a></li>
                    <li><a href="/CS%20340/phpmotors/vehicles/?action=Vehicle">Add Vehicle</a></li>
                </ul>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
