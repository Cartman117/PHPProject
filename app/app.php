<?php

require __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

use Model\InMemoryFinder;
use Model\JsonDAO;
use Model\Connection;
use Model\StatusQuery;
use Model\Status;
use Model\StatusDataMapper;
use Model\User;
use Model\UserQuery;
use Model\UserDataMapper;
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

// $memoryFinder = new InMemoryFinder();
// $memoryFinder = new JsonDAO($jsonFile);

$connection = new Connection("mysql", "uframework", "localhost", "uframework", "passw0rd");
$statusQuery = new StatusQuery($connection);
$userQuery = new UserQuery($connection);
$statusDataMapper = new StatusDataMapper($connection);
$userDataMapper = new UserDataMapper($connection);

/**
 * Index
 */
$app->get('/', function () use ($app) {
    $app->redirect('/statuses');
});

$app->get('/index', function () use ($app) {
    $app->redirect('/');
});

$app->get('/statuses', function (Request $request) use ($app, $statusQuery, $serializer) {
    session_start();
    $_SESSION['page'] = 'index';
    $statuses = $statusQuery->findAll(intval($request->getParameter("limit"), 10), $request->getParameter("orderBy"), $request->getParameter("direction"));
    $format = $request->guessBestFormat();
    if ('json' !== $format && 'xml' !== $format) {
        return $app->render('statuses.php', array('array' => $statuses));
    }
    $response = null;
    if ('json' === $format) {
        $response = new Response($serializer->serialize($statuses, $format), 200, array('Content-Type' => 'application/json'));
    }
    if ('xml' === $format) {
        $response = new Response($serializer->serialize($statuses, $format), 200, array('Content-Type' => 'application/xml'));
    }

    $response->send();
});

$app->get('/statuses/(\d+)', function (Request $request, $id) use ($app, $statusQuery, $serializer) {
    session_start();
    $_SESSION['page'] = 'status';
    $status = $statusQuery->findOneById($id);
    if (null === $status) {
        throw new HttpException(404, "Object doesn't exist");
    }

    $format = $request->guessBestFormat();
    if ('json' !== $format && 'xml' !== $format) {
        return $app->render('status.php', array('item' => $status));
    }
    $response = null;
    if ('json' === $format) {
        $response = new Response($serializer->serialize($status, $format), 200, array('Content-Type' => 'application/json'));
    }
    if ('xml' === $format) {
        $response = new Response($serializer->serialize($status, $format), 200, array('Content-Type' => 'application/xml'));
    }

    $response->send();
});

$app->get('/statuses/([a-zA-Z0-9]*)', function (Request $request, $username) use ($app, $statusQuery, $serializer) {
    session_start();
    $_SESSION['page'] = 'indexByPeople';
    if ($username !== $_SESSION['username']) {
        $app->redirect('/');
    }
    $statuses = $statusQuery->findAllByUser($username);
    $format = $request->guessBestFormat();
    if ('json' !== $format && 'xml' !== $format) {
        return $app->render('statuses.php', array('array' => $statuses));
    }
    $response = null;
    if ('json' === $format) {
        $response = new Response($serializer->serialize($statuses, $format), 200, array('Content-Type' => 'application/json'));
    }
    if ('xml' === $format) {
        $response = new Response($serializer->serialize($statuses, $format), 200, array('Content-Type' => 'application/xml'));
    }

    $response->send();
});

$app->post('/statuses', function (Request $request) use ($app, $statusDataMapper) {
    session_start();
    $author = null;
    if (isset($_SESSION['username'])) {
        $author = $_SESSION['username'];
    }
    if (!isset($_SESSION['username'])) {
        $author = 'Anonymous';
    }
    $content = $request->getParameter('message');
    $status = new Status($content, null, $author, new DateTime());
    $return = $statusDataMapper->persist($status);
    if (-1 === $return) {
        throw new HttpException(400, 'Status content too large (140 characters maximum).');
    }
    if (-2 === $return) {
        throw new HttpException(400, 'The content must be filled.');
    }

    $format = $request->guessBestFormat();
    if ('json' !== $format) {
        $app->redirect('/statuses');
    }
    $response = null;
    if ('json' === $format) {
        $response = new Response(json_encode($status), 201, array('Content-Type' => 'application/json'));
    }

    $response->send();
});

$app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app, $statusQuery, $statusDataMapper) {
    $status = $statusQuery->findOneById($id);
    if (null === $status) {
        throw new HttpException(404, "Object doesn't exist");
    }
    $statusDataMapper->remove($status);

    $format = $request->guessBestFormat();
    if ('json' !== $format) {
        $app->redirect('/statuses');
    }
    $response = null;
    if ('json' === $format) {
        $response = new Response("{\"status\": \"Status suppressed\"", 204, array('Content-Type' => 'application/json'));
    }

    $response->send();
});

$app->get('/signIn', function () use ($app) {
    return $app->render('signIn.php');
});

$app->get('/logIn', function () use ($app) {
    return $app->render('logIn.php');
});

$app->get('/logOut', function () use ($app) {
    session_start();
    session_destroy();

    return $app->redirect('/');
});

$app->post('/signIn', function (Request $request) use ($app, $userDataMapper) {
    $login = $request->getParameter("newLogin");
    $password = $request->getParameter("newPassword");
    $user = new User($login, $password);
    if ($user->isValid()) {
        $return = $userDataMapper->persist($user);
        if (-1 === $return) {
            throw new HttpException(400, 'Username or password fields too large (30 characters maximum).');
        }
        return $app->redirect('/');
    }
    throw new HttpException(409, "Username already exists or empty fields.");

});

$app->post('/logIn',  function (Request $request) use ($app, $userQuery) {
    $login = $request->getParameter("login");
    $password = $request->getParameter("password");
    if ($userQuery->findByUsernameAndPassword($login, $password)) {
        session_start();
        $_SESSION['username'] = $login;
        session_regenerate_id();
        return $app->redirect('/');
    }
    return $app->render('logIn.php', [ 'username'   => $login]);
});

return $app;
