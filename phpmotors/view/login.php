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
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                    } 
                    elseif (isset($message)) { 
                    echo $message; 
                    }
                    ?>
                <form method="post" action="/CS 340/phpmotors/accounts/index.php">
                    <label for="clientEmail"><b>Email</b></label><br>
                    <input type="email" placeholder="Enter Email" id="clientEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required>
                    <br><br>
                    <label for="clientPassword"><b>Password</b></label>
                    <p class="info-note">Passwords must be 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</p>
                    <input type="password" placeholder="Enter your password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                    <br><br>
                    <button type="submit">Sign-In</button>
                    <br><br>
                    <a class="text-link" href="/CS%20340/phpmotors/accounts/?action=Register">Not a member yet? Register for free!</a>
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="processLogin">
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
<?php unset($_SESSION['message']); ?>