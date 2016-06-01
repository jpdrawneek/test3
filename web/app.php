<?php

require_once '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request as Request,
 Symfony\Component\HttpFoundation\Response as Response;

define('WEB_ROOT', __DIR__);
define('PROJECT_ROOT', dirname(__DIR__));

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => PROJECT_ROOT . '/views',
));
// @todo look at putting these into a yaml config file.
$app['mongodb.url'] = 'mongodb://mm_recruitment_user_readonly:rebelMutualWhistle@ds037551.mongolab.com:37551/mm-recruitment';
$app['mongodb.collection'] = 'company';
$app['stock.uri'] = 'http://mm-recruitment-stock-price-api.herokuapp.com/company/';
//$app['debug'] = true;

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
  if ($code == 1234) {
    return new Response( $e->getMessage(), 404);
  }
  return new Response('We are sorry, but something went terribly wrong.', $code);
});

// @todo tidy this into custom app class, also add endpoint logic.
$app['TickerCodeEndpoint'] = function () use ($app) {
  return new \MergemarketTest\EndPoint\MongoDB($app['mongodb.url'], $app['mongodb.collection']);
};
// @todo tidy this into custom app class, also add endpoint logic.
$app['TickerCode'] = function () use ($app) {
  return new \MergemarketTest\TickerCodeLookup($app['TickerCodeEndpoint']);
};

$app['StockEndpoint'] = function () use ($app) {
  return new \MergemarketTest\EndPoint\Stock($app['stock.uri']);
};

$app['NewsEndpoint'] = function () use ($app) {
  return new \MergemarketTest\EndPoint\News();
};

$app['CompanyDetails'] = function () use ($app) {
  return new \MergemarketTest\CompanyDetails($app['TickerCode'], $app['StockEndpoint'], $app['NewsEndpoint']);
};

$app->get('/', function () use ($app) {
  $data = $app['TickerCode']->getList();
    return $app['twig']->render('index.html.twig', ['list' => $data]);
});

$app->get('/{ticker}', function ($CompanyDetail) use ($app) {
    return $app['twig']->render('company.twig', ['details' => $CompanyDetail]);
})->convert('CompanyDetail', function ($ticker, Request $request) use ($app) { 
  try {
  return $app['CompanyDetails']->getCompanyDetail($request->attributes->get('ticker')); 
  } catch (\Exception $e) {
    $app->abort(1234, "No Stock information for Ticker: " . $request->attributes->get('ticker'));
  }
  
});

return $app;
