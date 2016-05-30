<?php

require_once '../vendor/autoload.php';

define('WEB_ROOT', __DIR__);
define('PROJECT_ROOT', dirname(__DIR__));

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => PROJECT_ROOT . '/views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

return $app;
