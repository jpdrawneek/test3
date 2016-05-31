<?php

namespace MergemarketTest\Tests;

use \Mockery as m;

use MergemarketTest\TickerCodeLookup as TickerCodeLookup,
        MergemarketTest\Data\TickerCode as TickerCode;

/**
 * Description of TickerCodeLookupTest
 *
 * @author jpd
 */
class TickerCodeLookupTest extends \PHPUnit_Framework_TestCase {

  /** @var MergemarketTest\TickerCodeLookup */
  protected $object;

  public function setUp() {
    parent::setUp();
  }

  public function tearDown() {
    m::close();
  }

  public function testMongoDBEndPoint() {
    $app = new \Silex\Application();
    $app['TickerCodeEndpoint'] = m::mock('MergemarketTest\EndPoint\MongoDB');
    $this->object = new TickerCodeLookup($app['TickerCodeEndpoint']);
  }

  /**
   * @expected-Exception InvalidArgumentException
   */
//  public function testUnknownEndPoint() {
//    $app = new \Silex\Application();
//    $app['TickerCodeEndpoint'] = new \stdClass();
//    $this->object = new TickerCodeLookup($app['TickerCodeEndpoint']);
//  }

  public function testGetList() {
    $mongoDB = m::mock('MergemarketTest\EndPoint\MongoDB');
    $mongoDB->shouldReceive('getItems')->withNoArgs()->andReturn([
        new TickerCode('test1', 'code1'),
        new TickerCode('test2', 'code2')
    ]);
    $this->object = new TickerCodeLookup($mongoDB);
    $result = $this->object->getList();
    $this->assertTrue(is_array($result), 'Should have returned an array');
    $this->assertNotEmpty($result, 'Should have results in it');
    $this->assertEquals(count($result), 2, 'Should only have two results');
    $this->assertEquals($result[0], new TickerCode('test1', 'code1'));
    $this->assertEquals($result[1], new TickerCode('test2', 'code2'));
  }
  
  public function testGetByTicker() {
    $mongoDB = m::mock('MergemarketTest\EndPoint\MongoDB');
    $mongoDB->shouldReceive('getByTicker')->withArgs(['code1'])->once()->andReturn(
        new TickerCode('test1', 'code1')
    );
    $this->object = new TickerCodeLookup($mongoDB);
    $result = $this->object->getByTicker('code1');
    $this->assertInstanceOf('\MergemarketTest\Data\TickerCode', $result, 'Should have returned a object of TickerCode');
    $this->assertNotEmpty($result, 'Should have results in it');
    $this->assertEquals($result, new TickerCode('test1', 'code1'));;
  }

}
