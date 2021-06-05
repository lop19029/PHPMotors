<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Add Classification</title>
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
                <h1>Add Car Classification</h1>
                <!-- Display feedback message -->
                <?php
                    if(isset($message)) {
                        echo $message;
                    }
                ?>
                <form method="post" action="/CS%20340/phpmotors/vehicles/index.php">
                    <label for="classificationName">Classification Name</label><br>
                    <input type="text" placeholder="Luxury" id="classificationName" name="classificationName" required>
                    <br><br>
                    <button type="submit" name="submit" id="classbtn" value="Add Classification">Add Classification</button>
                    
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="addClassification">
                </form>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>
