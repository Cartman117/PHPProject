<?php

require __DIR__ . '/../autoload.php';

use Model\InMemoryFinder;
use Model\JsonFinder;
use Model\Status;
use Http\Request;
use Exception\HttpException;

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$jsonFile = __DIR__ .  DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'statuses.json';

/**
 * Index
 */
$app->get('/', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/index', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/statuses', function (Request $request) use ($app, $jsonFile) {
    // $memoryFinder = new InMemoryFinder();
    $memoryFinder = new JsonFinder($jsonFile);
    $statuses = $memoryFinder->findAll();

    return $app->render('statuses.php', array('array' => $statuses));
});

$app->get('/statuses/(\d+)', function (Request $request, $id) use ($app, $jsonFile) {
    // $memoryFinder = new InMemoryFinder();
    $memoryFinder = new JsonFinder($jsonFile);
    $status = $memoryFinder->findOneById($id);
    if (null === $status) {
        throw new HttpException(404, 'Page not found. False status id.');
    }

    return $app->render('status.php', array('item' => $status));
});

$app->post('/statuses', function (Request $request) use ($app, $jsonFile) {
    $memoryFinder = new JsonFinder($jsonFile);
    $author = $request->getParameter('username');
    $content = $request->getParameter('message');
    $memoryFinder->addNewStatus(new Status($content, Status::getNextId($jsonFile), $author, new DateTime()));

    $app->redirect('/statuses', 201);
});

return $app;
