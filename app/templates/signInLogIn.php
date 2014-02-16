<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Index</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
<?php
    if (!isset($_SESSION['username'])) {
?>
        <li>
            <a href="/signIn">Sign In</a>
        </li>
        <li>
            <a href="/logIn">Log In</a>
        </li>
<?php
    }
    if (isset($_SESSION['username'])) {
?>
        <li>
            <a href="/logOut">Log Out</a>
        </li>
<?php
    }
    if (isset($_SESSION['page'])) {
        switch ($_SESSION['page']) {
            case "index":
                if (isset($_SESSION['username'])) {
?>
                    <li>
                        <a href="/statuses/<?=$_SESSION['username']?>">List statuses you wrote</a>
                    </li>
<?php
                }
                break;
            case "status":
                if (isset($_SESSION['username'])) {
?>
                    <li>
                        <a href="/statuses/<?=$_SESSION['username']?>">List statuses you wrote</a>
                    </li>
<?php
                }
                break;
        }
    }
?>
            </ul>
        </div>
    </div>
</nav>


<?php
    if (isset($_SESSION['username'])) {
?>
        <div class="container">
            <div class="alert alert-info">
                <strong><?=$_SESSION['username']?></strong> is connected
            </div>
        </div>
<?php
    }