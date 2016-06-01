<?php

namespace MergemarketTest\Tests;

use \Mockery as m;
use MergemarketTest\Data\CompanyDetail as CompanyDetail;

/**
 * Description of CompantDetailTest
 *
 * @author jpd
 */
class CompanyDetailTest extends \PHPUnit_Framework_TestCase {
  
  /** @var MergemarketTest\Data\CompanyDetail */
  protected $object;

  public function setUp() {
    parent::setUp();
    $tickerCode = m::mock('\MergemarketTest\Data\TickerCode');
    $this->object = new CompanyDetail($tickerCode, (object)["tickerCode" => "code1",
   "latestPrice" => 54407,
   "priceUnits" => "GBP:pence",
   "asOf" => "2015-05-06T15:05:59.912Z",
   "storyFeedUrl" => "http://mm-recruitment-story-feed-api.herokuapp.com/1234"], []);
  }

  public function tearDown() {
    m::close();
  }
  
  public function testFixCurrency() {
    
    $this->assertEquals('54407p', $this->object->fixCurrency('54407', 'GBP:pence'));
  }
  
  public function testSetPositivity() {
    $tickerCode = m::mock('\MergemarketTest\Data\TickerCode');
    $newsItems = [
        (object)["id" => 1,
        "headline" => "Make up a positive headline",
        "body" => "Body with enough words to trigger positive sentiment analysis"]
    ];
    $mockStock = (object)['latestPrice' => 1234, 'priceUnits' => 'ZXX:stuff'];
    $object = new CompanyDetail($tickerCode, $mockStock, $newsItems);
    $this->assertEquals('positive', $object->latestNews[0]->sentimentAnalysis);
  }
  
  public function testCalculatePositivity() {
    $this->assertEquals('neutral', $this->object->calculatePositivity(
      (object)["id" => 1,
        "headline" => "Make up a positive headline",
        "body" => "Body with enough words to trigger sentiment analysis"]
    ));
    $this->assertEquals('neutral', $this->object->calculatePositivity(
      (object)["id" => 1,
        "headline" => "Make up a headline",
        "body" => "Body with enough words to trigger positive sentiment analysis"]
    ));
    $this->assertEquals('positive', $this->object->calculatePositivity(
      (object)["id" => 1,
        "headline" => "Make up a positive headline",
        "body" => "Body with enough words to trigger positive sentiment analysis"]
    ));
    $this->assertEquals('negative', $this->object->calculatePositivity(
      (object)["id" => 1,
        "headline" => "Make up a disappointing headline",
        "body" => "Body with enough words to trigger disappointing sentiment analysis"]
    ));
  }
}
