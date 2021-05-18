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
                <form>
                    <p class="info-note">*All the fields are required.</p>
                    <label for="clientFirstname"><b>First name</b></label><br>
                    <input type="text" placeholder="John" id="clientFirstname" name="clientFirstname" required>
                    <br>
                    <label for="clientLastName"><b>Last name</b></label><br>
                    <input type="text" placeholder="Doe" id="clientLastName" name="clientLastName" required>
                    <br>
                    <label for="clientEmail"><b>Email</b></label><br>
                    <input type="text" placeholder="jhondoe@myemail.com" id="clientEmail" name="clientEmail" required>
                    <br>
                    <p class="info-note">Passwords must be 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</p>
                    <label for="clientPassword"><b>Password</b></label><br>
                    <input type="text" placeholder="Enter your password" id="clientPassword" name="clientPassword" required><br>
                    <label><input type="checkbox" name="showPassword">Show password</label>
                    <br>
                    <button type="button">Register</button>
                    <br>
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>