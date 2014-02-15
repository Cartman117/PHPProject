<!DOCTYPE HTML>
<html lang='en'>
    <head>
        <title>Statuses</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
    <?php
        require_once 'signInLogIn.php';
    ?>
        <div class='statuses'>
            <h3>Status list:</h3>
        </div>
    <?php
            foreach ($parameters['array'] as $status) {
                echo $status;
                if (isset($_SESSION['username']) && $_SESSION['username'] === $status->getUsername()) {
    ?>
                    <form action="/statuses/<?= $status->getId() ?>" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="Delete">
                    </form>
    <?php
                }
            }
    ?>
        <form action="/statuses" method="POST">
            <label for="message">Message:</label>
            <textarea name="message"></textarea>

            <input type="submit" value="Tweet!">
        </form>
    </body>
</html>
