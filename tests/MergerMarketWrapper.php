<?php

namespace MergemarketTest\Tests;

use Silex\WebTestCase;

/**
 * Description of MergerMarketWrapper
 *
 * @author jpd
 */
abstract class MergerMarketWrapper extends WebTestCase {

  public function createApplication() {
    $app = require __DIR__ . '/../web/app.php';
    $app['debug'] = true;
    unset($app['exception_handler']);

    return $app;
  }

}
