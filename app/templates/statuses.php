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
            }
        ?>
        <form action="/statuses" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username">

            <label for="message">Message:</label>
            <textarea name="message"></textarea>

            <input type="submit" value="Tweet!">
        </form>
    </body>
</html>
