<header>
    <a href="/CS%20340/phpmotors/index.php"><img class="logo" src="../images/site/logo.png" alt="logo"></a>
    <?php 
        if(isset($_SESSION['loggedin'])){
            $userName = $_SESSION['clientData']['clientFirstname'];
            echo "<span><a href='/CS%20340/phpmotors/accounts'> Logged as: $userName</a></span>";
        }
    ?><a href="/CS%20340/phpmotors/accounts/index.php?action=Login">My Account</a>
</header>