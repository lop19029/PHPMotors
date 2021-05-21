<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Login</title>
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
                <div><h1>Sign In</h1></div> 
                <?php
                    if(isset($message)) {
                        echo $message;
                    }
                    ?>
                <form>
                    <label for="clientEmail"><b>Email</b></label><br>
                    <input type="text" placeholder="Enter Email" id="clientEmail" name="clientEmail" required>
                    <br>
                    <label for="clientPassword"><b>Password</b></label><br>
                    <input type="text" placeholder="Enter your password" id="clientPassword" name="clientPassword" required>
                    <br><br>
                    <button type="button">Sign-In</button>
                    <br><br>
                    <a class="text-link" href="/CS%20340/phpmotors/accounts/?action=Register">Not a member yet? Register for free!</a>
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>