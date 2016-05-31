<?php

namespace MergemarketTest\Data;

/**
 * Description of TickerCode
 *
 * @author jpd
 */
class TickerCode {

  protected $companyName;
  protected $companyTicker;

  public function __construct($companyName, $companyTicker) {
    $this->companyName = $companyName;
    $this->companyTicker = $companyTicker;
  }

  public function __get($name) {
    return $this->$name;
  }

  public function __isset($name) {
    
    return isset($this->$name);
  }

}
