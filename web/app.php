<?php

require_once '../vendor/autoload.php';

define('WEB_ROOT', __DIR__);
define('PROJECT_ROOT', dirname(__DIR__));

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => PROJECT_ROOT . '/views',
));
// @todo look at putting these into a yaml config file.
$app['mongodb.url'] = 'mongodb://mm_recruitment_user_readonly:rebelMutualWhistle@ds037551.mongolab.com:37551/mm-recruitment';
$app['mongodb.collection'] = 'company';

// @todo tidy this into custom app class, also add endpoint logic.
$app['TickerCodeEndpoint'] = function () use ($app) {
  return new \MergemarketTest\EndPoint\MongoDB($app['mongodb.url'], $app['mongodb.collection']);
};
// @todo tidy this into custom app class, also add endpoint logic.
$app['TickerCode'] = function () use ($app) {
  return new \MergemarketTest\TickerCodeLookup($app['TickerCodeEndpoint']);
};

$app->get('/', function () use ($app) {
  $data = $app['TickerCode']->getList();
  print '<pre>' . print_r($data, TRUE) . '</pre>';
    return $app['twig']->render('index.html.twig', ['list' => $data]);
});

return $app;
