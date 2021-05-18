<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset = "UTF-8">
        <title>PHP Motors - Error 500</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen">
    </head>
    <body>
        <div class = "page-wrapper">
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/header.php'; ?> 
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/nav.php'; ?>
            <main>
                <h1 class="error-head">Server Error</h1>
                <p class="error-message">Sorry our server seems to be experiencing some technical difficulties</p>
            </main>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/CS 340/phpmotors/snippets/footer.php'; ?>
        </div>
    </body>
</html>