<!DOCTYPE HTML>
<html lang='en'>
<head>
    <title>Status</title>
    <meta charset="UTF-8"/>
</head>
<body>
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
