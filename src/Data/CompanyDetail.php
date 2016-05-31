<?php

namespace MergemarketTest\Data;

/**
 * Description of CompanyDetail
 *
 * @author jpd
 */
class CompanyDetail {
  
  protected $name;
  protected $symbol;
  protected $price;
  protected $latestNews;

  public function __construct(TickerCode $ticket, \stdClass $stock, array $news) {
    $this->name = $ticket->companyName;
    $this->symbol = $ticket->companyTicker;
    $this->price = $stock->latestPrice;
    $this->latestNews = $this->sortNews($news);
  }
  
  protected function sortNews($news) {
    $output = [];
    for ($x=0; $x< 2; $x++) {
      $item = array_shift($news);
      if (isset($item)) {
        $output[] = $item;
      }
    }
    return $output;
  }


  public function __get($name) {
    return $this->$name;
  }

  public function __isset($name) {
    
    return isset($this->$name);
  }
}
