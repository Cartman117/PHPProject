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
    if (isset($_SESSION['page'])) {
        switch ($_SESSION['page']) {
            case "index":
                if (isset($_SESSION['username'])) {
?>
                    <form action="/statuses/<?=$_SESSION['username']?>" method="GET">
                        <input type="submit" class="submit" value="List statuses you wrote"/>
                    </form>
<?php
                }
                break;
            case "indexByPeople":
?>
                <form action="/" method="GET">
                    <input type="submit" class="submit" value="Index"/>
                </form>
<?php
                break;
            case "status":
?>
                <form action="/" method="GET">
                    <input type="submit" class="submit" value="Index"/>
                </form>
<?php
                if (isset($_SESSION['username'])) {
?>

                    <form action="/statuses/<?=$_SESSION['username']?>" method="GET">
                        <input type="submit" class="submit" value="List statuses you wrote"/>
                    </form>
<?php
                }
                break;
        }
    }
