<?php

namespace MergemarketTest;

use MergemarketTest\EndPoint\TickerEndPoint as TickerEndPoint;

/**
 * Description of TickerCodeLookup
 *
 * @author jpd
 */
class TickerCodeLookup {

  /** @var \MergemarketTest\EndPoint\TickerEndPoint */
  protected $endPoint;

  public function __construct(TickerEndPoint $endPoint) {
    $this->endPoint = $endPoint;
  }

  /**
   * 
   * @return array
   *   Returns a list of TickerCode objects to be used.
   */
  public function getList() {
    // Caching could go in here.
    $output = $this->endPoint->getItems();
    return $output;
  }

}
