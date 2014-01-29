<?php

require __DIR__ . '/../autoload.php';

use Model\InMemoryFinder;
use Model\JsonFinder;
use Model\Status;

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

$app->get('/statuses', function () use ($app, $jsonFile) {
    // $memoryFinder = new InMemoryFinder();
    $memoryFinder = new JsonFinder($jsonFile);
    $statuses = $memoryFinder->findAll();
    return $app->render('statuses.php', array('array' => $statuses));
});

$app->get('/statuses/(\d+)', function ($id) use ($app, $jsonFile) {
    // $memoryFinder = new InMemoryFinder();
    $memoryFinder = new JsonFinder($jsonFile);
    $status = $memoryFinder->findOneById($id);
    return $app->render('status.php', array('item' => $status));
});

return $app;
