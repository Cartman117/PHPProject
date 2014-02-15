<!DOCTYPE HTML>
<html lang='en'>
<head>
    <title>Status</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
</head>
<body>
    <header class="page-header">
        <h1>Statuses</h1>
    </header>
    <?php
        require_once 'signInLogIn.php';
        echo '<br/>' . $parameters['item'];
        if (isset($_SESSION['username']) && $_SESSION['username'] === $parameters['item']->getUsername()) {
    ?>
            <form action="/statuses/<?= $parameters['item']->getId() ?>" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" value="Delete">
            </form>
    <?php
        }
    ?>
</body>
</html>
