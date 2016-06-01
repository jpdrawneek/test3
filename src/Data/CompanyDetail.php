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
    $this->price = $this->fixCurrency($stock->latestPrice, $stock->priceUnits);
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
  
  public function calculatePositivity(\stdClass $newsItem) {
    return 'none';
  }

  /**
   * Simple switch to handle basic cases.
   * @todo If more currencies used expand out into using libraries.
   *
   * @param string $value
   * @param string $currency
   * @return string
   */
  public function fixCurrency($value, $currency) {
    switch ($currency) {
      case 'GBP:pence':
        $output = $value . 'p';
        break;
      default:
        $output = $value . ' ' . $currency;
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
