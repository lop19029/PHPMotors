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
        <title>PHP Motors - Update User Information</title>
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
                <?php
                    if(isset($accountMessage)) {
                        echo $accountMessage;
                    }
                ?>
                <div><h1>Manage Account</h1><div>
                <form method="post" action="/CS 340/phpmotors/accounts/index.php">
                    <p class="info-note">*All the fields are required.</p>
                    <label for="clientFirstname"><b>First name</b></label><br>
                    <input type="text" id="clientFirstname" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} elseif(isset($clientInfo['clientFirstname'])) {echo "value='$clientInfo[clientFirstname]'"; }  ?> required>
                    <br>
                    <label for="clientLastname"><b>Last name</b></label><br>
                    <input type="text" id="clientLastname" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} elseif(isset($clientInfo['clientLastname'])) {echo "value='$clientInfo[clientLastname]'"; } ?> required>
                    <br>
                    <label for="clientEmail"><b>Email</b></label><br>
                    <input type="email" id="clientEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} elseif(isset($clientInfo['clientEmail'])) {echo "value='$clientInfo[clientEmail]'"; }  ?> required>
                    <br>
                    <button type="submit" name="submit" value="Update User">Update Info</button>
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="processClientUpdate">
                    <br>
                </form>
                <?php
                    if(isset($passwordMessage)) {
                        echo $passwordMessage;
                    }
                ?>
                <div><h1>Change Password</h1><div>
                <form method="post" action="/CS 340/phpmotors/accounts/index.php">
                    <p class="info-note">Passwords must be 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</p>
                    <label for="clientPassword"><b>Password</b></label><br>
                    <input type="password" placeholder="Enter your password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
                    <label><input type="checkbox" name="showPassword">Show password</label>
                    <br>
                    <button type="submit" name="submit" value="Update Password">Change Password</button>
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="updateClientPassword">
                    <br>
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>