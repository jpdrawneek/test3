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
        $item->sentimentAnalysis = $this->calculatePositivity($item);
        $output[] = $item;
      }
    }
    return $output;
  }
  
  public function calculatePositivity(\stdClass $newsItem) {
    $positiveWords = ['positive', 'success', 'grow', 'gains', 'happy', 'healthy'];
    $negativeWords = ['disappointing', 'concerns', 'decline', 'drag', 'slump', 'feared'];
    $searchString = preg_replace("/[^A-Za-z0-9 ]/", '', $newsItem->headline . ' ' . $newsItem->body);
    $textToCount = explode(' ', $searchString);
    $words = array_count_values($textToCount);
    $total = 0;
    foreach ($positiveWords AS $word) {
      if (isset($words[$word])) {
        $total += $words[$word];
      }
    }
    foreach ($negativeWords AS $word) {
      if (isset($words[$word])) {
        $total -= $words[$word];
      }
    }
    if ( $total > 1) {
      return 'positive';
    } elseif ($total < 0) {
      return 'negative';
    } else {
      return 'neutral';
    }
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
