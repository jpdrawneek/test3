<?php

namespace MergemarketTest\Tests;

use Silex\WebTestCase;

/**
 * Description of HelloWorld
 *
 * @author jpd
 */
class HelloWorldTest extends WebTestCase {

  public function createApplication() {
    $app = require __DIR__ . '/../web/app.php';
    $app['debug'] = true;
    unset($app['exception_handler']);

    return $app;
  }

  function testHelloWorld() {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/');

    $this->assertTrue($client->getResponse()->isOk());
    $this->assertCount(1, $crawler->filter('h1:contains("Hello World")'));
  }

}
