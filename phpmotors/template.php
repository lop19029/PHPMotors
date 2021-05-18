<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/styles.css" media="screen">
    </head>
    <body>
        <div class = "page-wrapper">
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/header.php'; ?> 
                <?php echo $navList;?>
            <main>
                <h1>Content Title Here</h1>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>