<!DOCTYPE HTML>
<html lang='en'>
<head>
    <title>Status</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
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
        <h3><span class="label label-default">Status</span></h3>
    <?php
        echo '<br/>' . $parameters['item'];
        if (isset($_SESSION['username']) && $_SESSION['username'] === $parameters['item']->getUsername()) {
    ?>

        <div class="panel panel-default panel-tweet-more">
            <div class="panel-body">
            <form action="/statuses/<?= $parameters['item']->getId() ?>" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" value="Delete" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
            </form>
            </div>
        </div>
    <?php
        }
    ?>
    </div>
</body>
</html>
