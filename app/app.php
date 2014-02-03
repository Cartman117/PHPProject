<?php

require __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

use Model\InMemoryFinder;
use Model\JsonFinder;
use Model\Status;
use Http\Request;
use Http\Response;
use Exception\HttpException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$jsonFile = __DIR__ .  DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'statuses.json';
$encoders = array(new XmlEncoder(), new JsonEncoder());
$normalizers = array(new GetSetMethodNormalizer());
$serializer = new Serializer($normalizers, $encoders);

/**
 * Index
 */
$app->get('/', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/index', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/statuses', function (Request $request) use ($app, $jsonFile, $serializer) {
    // $memoryFinder = new InMemoryFinder();
    $memoryFinder = new JsonFinder($jsonFile);
    $statuses = $memoryFinder->findAll();
    $format = $request->guessBestFormat();
    if ('html' === $format) {
        return $app->render('statuses.php', array('array' => $statuses));
    }
    $response = new Response($serializer->serialize($statuses, $format));

    $response->send();
});

$app->get('/statuses/(\d+)', function (Request $request, $id) use ($app, $jsonFile, $serializer) {
    // $memoryFinder = new InMemoryFinder();
    $memoryFinder = new JsonFinder($jsonFile);
    $status = $memoryFinder->findOneById($id);
    if (null === $status) {
        throw new HttpException(404, "Object doesn't exist");
    }
    $format = $request->guessBestFormat();
    if ('html' === $format) {

        return $app->render('status.php', array('item' => $status));
    }
    $response = new Response($serializer->serialize($status, $format));

    $response->send();
});

$app->post('/statuses', function (Request $request) use ($app, $jsonFile) {
    $memoryFinder = new JsonFinder($jsonFile);
    $author = $request->getParameter('username');
    $content = $request->getParameter('message');
    $memoryFinder->addNewStatus(new Status($content, Status::getNextId($jsonFile), $author, new DateTime()));

    $app->redirect('/statuses');
});

$app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app, $jsonFile) {
    $memoryFinder = new JsonFinder($jsonFile);
    $status = $memoryFinder->findOneById($id);
    if (null === $status) {
        throw new HttpException(404, "Object doesn't exist");
    }
    $memoryFinder->deleteStatus($status);

    $app->redirect('/statuses');
});

return $app;
