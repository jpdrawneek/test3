<?php

namespace MergemarketTest\Tests;

use \Mockery as m;

use MergemarketTest\CompanyDetails as CompanyDetails,
        MergemarketTest\Data\TickerCode as TickerCode,
        MergemarketTest\Data\CompanyDetail as CompanyDetail;

/**
 * Description of CompanyDetailsTest
 *
 * @author jpd
 */
class CompanyDetailsTest extends \PHPUnit_Framework_TestCase {
  
  public function setUp() {
    parent::setUp();
  }

  public function tearDown() {
    m::close();
  }
  
  public function testGetCompanyDetail() {
    $app = new \Silex\Application();
    $app['TickerCode'] = m::mock('\MergemarketTest\TickerCodeLookup');
    $app['TickerCode']->shouldReceive('getByTicker')->withArgs(['code1'])->once()->andReturn(
        new TickerCode('test1', 'code1')
    );
    $app['StockEndpoint'] = m::mock('\MergemarketTest\EndPoint\Stock');
    $app['StockEndpoint']->shouldReceive('getByTicker')->withArgs(['code1'])->once()->andReturn(
        (object)["tickerCode" => "code1",
   "latestPrice" => 54407,
   "priceUnits" => "GBP:pence",
   "asOf" => "2015-05-06T15:05:59.912Z",
   "storyFeedUrl" => "http://mm-recruitment-story-feed-api.herokuapp.com/1234"]
    );
    $app['NewsEndpoint'] = m::mock('\MergemarketTest\EndPoint\News');
    $app['NewsEndpoint']->shouldReceive('getStoryFeedUrl')->withArgs(['http://mm-recruitment-story-feed-api.herokuapp.com/1234'])->once()->andReturn(
        [
    (object)[
        "id" => 1,
        "headline" => "Make up a headline",
        "body" => "Body with enough words to trigger sentiment analysis"
    ],
    (object)[
        "id" => 2,
        "headline" => "Make up a headline",
        "body" => "Body with enough words to trigger sentiment analysis"
    ]
]
    );
    $this->object = new CompanyDetails($app['TickerCode'], $app['StockEndpoint'], $app['NewsEndpoint']);
    $result = $this->object->getCompanyDetail('code1');
    $this->assertInstanceOf('MergemarketTest\Data\CompanyDetail', $result, 'Should have returned a object of CompanyDetail');
    $this->assertEquals('test1', $result->name);
    $this->assertEquals('54407', $result->price);
    $this->assertEquals(2, count($result->latestNews));
  }
}
