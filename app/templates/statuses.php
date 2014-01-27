<!DOCTYPE HTML>
<html lang='en'>
    <head>
        <title>Statuses</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <div class='statuses'>
            <h3>Status list:</h3>
        </div>
        <?php
            foreach($parameters['array'] as $status) {
                echo $status;
            }
        ?>
    </body>
</html>
