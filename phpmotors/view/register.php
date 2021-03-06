<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Registration</title>
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
                <h1>Register</h1>
                <form method="post" action="/CS 340/phpmotors/accounts/index.php">

                    <?php
                    if(isset($message)) {
                        echo $message;
                    }

                    ?>

                    <p class="info-note">*All the fields are required.</p>
                    <label for="clientFirstname"><b>First name</b></label><br>
                    <input type="text" placeholder="John" id="clientFirstname" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> required>
                    <br>
                    <label for="clientLastname"><b>Last name</b></label><br>
                    <input type="text" placeholder="Doe" id="clientLastname" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?> required>
                    <br>
                    <label for="clientEmail"><b>Email</b></label><br>
                    <input type="email" placeholder="jhondoe@myemail.com" id="clientEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required>
                    <br>
                    <p class="info-note">Passwords must be 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</p>
                    <label for="clientPassword"><b>Password</b></label><br>
                    <input type="password" placeholder="Enter your password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
                    <label><input type="checkbox" name="showPassword">Show password</label>
                    <br>
                    <button type="submit" name="submit" id="regbtn" value="Register">Register</button>
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="register">
                    <br>
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>