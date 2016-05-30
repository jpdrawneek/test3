<?php

namespace MergemarketTest\Tests;

/**
 * Description of HelloWorld
 *
 * @author jpd
 */
class HelloWorldTest extends MergerMarketWrapper {

  function testHelloWorld() {
    $client = $this->createClient();
    $crawler = $client->request('GET', '/');

    $this->assertTrue($client->getResponse()->isOk());
    $this->assertCount(1, $crawler->filter('h1:contains("Hello World")'));
  }

}
