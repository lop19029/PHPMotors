<?php 
//Add some code here


?><!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen">
    </head>
    <body>
        <div class = "page-wrapper">
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/header.php'; ?> 
            <?php echo $navList;?>
            <main>
                <h1><?php echo echo $_SESSION['clientData']['clientFirstname'], '&nbsp;', $_SESSION['clientData']['clientLastname'];?></h1>
                <p>You are logged in.</p>
                <br>
                <ul>
                    <li>First name: <?php echo $_SESSION['clientData']['clientFirstname'];?></li>
                    <li>Last name: <?php echo $_SESSION['clientData']['clientLastname'];?></li>
                    <li>Email: <?php echo $_SESSION['clientData']['clientEmail'];?></li>
                </ul>
                <br>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>