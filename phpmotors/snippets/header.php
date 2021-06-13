<header>
    <a href="/CS%20340/phpmotors/index.php"><img class="logo" src="../images/site/logo.png" alt="logo"></a>
    <?php 
        if(isset($_SESSION['loggedin'])){
            $userName = $_SESSION['clientData']['clientFirstname'];
            echo "<span><a href='/CS%20340/phpmotors/accounts'> Welcome $userName</a></span>";
            echo "<a href='/CS%20340/phpmotors/accounts/?action=Logout'>Logout</a>";
        }
        else {
            echo '<a href="/CS%20340/phpmotors/accounts/?action=Login">My Account</a>';
        }
    ?>
</header>