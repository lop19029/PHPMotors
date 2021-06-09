<!DOCTYPE html>
<?php

//Define cookie parameters

$cookie_name = 'mycookie';
$cookie_value = 'Something useful';
$cookie_expireTime = time() + (86400 * 30);
$cookie_path = '/';

//Create cookie
//setcookie($cookie_name, $cookie_value, $cookie_expireTime, $cookie_path);

//Delete cookie
if (isset($_COOKIE[$cookie_name])) {
     unset($_COOKIE[$cookie_name]);
     setcookie($cookie_name, '', $cookie_expireTime, $cookie_path); // empty value and old parameters
}
?>

<html>
<body>

<?php
if(!isset($_COOKIE[$cookie_name])) {
     echo "The cookie named '" . $cookie_name . "' is not set! You might have to reload the page.";
} else {
     echo "Cookie named '" . $cookie_name . "' is set and ready to work!<br>";
     echo "Its value is: " . $_COOKIE[$cookie_name];
}
?>

</body>
</html>