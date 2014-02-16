<!DOCTYPE HTML>
<html lang='en'>
<head>
    <title>Log In</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header class="page-header navbar navbar-static-top">
        <div class="container">
            <h1>Statuses</h1>
        </div>
    </header>
    <?php
    require_once 'signInLogIn.php';
    ?>
    <div class="container">
        <h3><span class="label label-default">Log In</span></h3>
        <div id="login">
            <form method="post" action="/logIn">
                <input type="text" placeholder="Login" name="login" id="login" class="form-control"/><br/>
                <input type="password" placeholder="Password" name="password" id="password" class="form-control"/><br/>
                <input type="submit" value="Log in" class="form-control"/>
            </form>
        </div>
    </div>
</body>
</html>
