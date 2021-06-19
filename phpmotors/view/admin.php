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
        <title>PHP Motors - My Account</title>
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
                <h1><?php echo $_SESSION['clientData']['clientFirstname'], '&nbsp;', $_SESSION['clientData']['clientLastname'];?></h1>
                <p>You are logged in.</p>
                <br>
                <ul>
                    <li>First name: <?php echo $_SESSION['clientData']['clientFirstname'];?></li>
                    <li>Last name: <?php echo $_SESSION['clientData']['clientLastname'];?></li>
                    <li>Email: <?php echo $_SESSION['clientData']['clientEmail'];?></li>
                </ul>
                <br>
                <?php if(isset($accountMessage)) { 
                    echo $message; 
                    }
                    ?>
                <h2>Account management</h2>
                <p>Use this link to update account information</p>
                <a class="text-link" href="/CS%20340/phpmotors/accounts/?action=updateClient">Update Account Information</a>
                <br>
                <?php 
                    if(isset($adminLink)){
                        if(isset($accountMessage)) { 
                            echo $message; 
                        }
                        echo "<h2>Vehicle Management</h2><p>Use this link to manage the inventory</p>";

                        echo $adminLink;
                    }
                ?>
                <br>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>