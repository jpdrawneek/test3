<?php

namespace MergemarketTest\EndPoint;

/**
 * Description of Stock
 *
 * @author jpd
 */
class Stock extends GetJson {
  
  protected $uri;
  
  public function __construct($uri) {
    $this->uri = $uri;
  }
  
  public function getByTicker($ticker) {
    $return = $this->doRequest($this->uri . $ticker);
    return json_decode($return);
  }
}
