<?php

/*
* Proxy connections for the phpmotors database
*/
function phpmotorsConnect()
{
    $server = 'localhost';
    $dbname = 'phpmotors';
    $username = 'iclient';
    $password = 'KG@[R[LOEIkV06[H';
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
        
    } catch (PDOException $e) {
        header("Location: /CS%20340/phpmotors/view/500.php");
        exit;
    }
}