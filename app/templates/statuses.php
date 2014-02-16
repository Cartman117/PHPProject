<!DOCTYPE HTML>
<html lang='en'>
<head>
    <title>Statuses</title>
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
        <form action="/statuses" method="POST">
            <label for="message"><h3><span class="label label-default">Message</span></h3></label><br/>
            <div class="input-group">
                <textarea name="message" class="form-control"></textarea>
                <span class="input-group-addon"><input type="submit" value="Tweet!" class="btn btn-default"></span>
            </div>
        </form>

        <h3><span class="label label-default">Status list</span></h3>

        <?php
        foreach ($parameters['array'] as $status) {
            echo $status;
        ?>
            <div class="panel panel-default panel-tweet-more">
                <div class="panel-body">
                    <a href="./statuses/<?= $status->getId() ?>" class="btn btn-default"><span class="glyphicon glyphicon-zoom-in"></span></a>
        <?php
            if (isset($_SESSION['username']) && $_SESSION['username'] === $status->getUsername()) {
                ?>
                    <form action="/statuses/<?= $status->getId() ?>" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" value="Delete" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                    </form>
            <?php
            }
            ?>
                </div>
            </div>
            <br/>
            <?php
        }
        ?>
    </div>
</body>
</html>