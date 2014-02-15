<!DOCTYPE HTML>
<html lang='en'>
<head>
    <title>Status</title>
    <meta charset="UTF-8"/>
</head>
<body>
    <?php
        require_once 'signInLogIn.php';
        echo $parameters['item'];
    ?>
    <form action="/statuses/<?= $parameters['item']->getId() ?>" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="Delete">
    </form>
</body>
</html>
