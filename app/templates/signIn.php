<!DOCTYPE HTML>
<html lang='en'>
<head>
    <title>Sign In</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost:8082/css/main.css">
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
        <div id="signIn">
            <h3><span class="label label-default">Sign In</span></h3>
            <form method="post" action="/signIn">
                <input type="text" placeholder="Login" name="newLogin" id="newLogin" class="form-control"/><br/>
                <input type="password" placeholder="Password" name="newPassword" id="newPassword" class="form-control"/><br/>
                <input type="submit" value="Sign in"  class="form-control"/>
            </form>
        </div>
    </div>
</body>
</html>
