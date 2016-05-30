<?php
/**
 * No tests in this as class is probably going to be a light wrapper around PHP MongoDB extension.
 */

namespace MergemarketTest\Tests;

use MergemarketTest\EndPoint\MongoDB;

/**
 * Description of MongoDBEndPointTest
 *
 * @author jpd
 */
class MongoDBEndPointTest extends \PHPUnit_Framework_TestCase {
  
  /** @var MergemarketTest\EndPoint\MongoDB */
  protected $object;
  
  public function setUp() {
    parent::setUp();
    $this->object = new MongoDB();
  }
}
