<?php
    if (!isset($_SESSION['username'])) {
?>
        <form action="/signIn" method="GET">
            <input type="submit" class="submit" value="Sign In"/>
        </form>
        <form action="/logIn" method="GET">
            <input type="submit" class="submit" value="Log In"/>
        </form>
<?php
    }
    if (isset($_SESSION['username'])) {
        echo $_SESSION['username'] . ' is connected';
?>
        <form action="/logOut" method="GET">
            <input type="submit" class="submit" value="Log Out"/>
        </form>
<?php
    }
?>


