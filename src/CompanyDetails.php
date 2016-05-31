<?php

namespace MergemarketTest;

use MergemarketTest\EndPoint\Stock as Stock,
        MergemarketTest\EndPoint\News as News,
        MergemarketTest\Data\CompanyDetail as CompanyDetail;

/**
 * Description of CompanyDetails
 *
 * @author jpd
 */
class CompanyDetails {
  /** @var \MergemarketTest\TickerCodeLookup */
  protected $tickerCodeLookup;
  /** @var \MergemarketTest\EndPoint\Stock */
  protected $stockEndPoint;
  /** @var \MergemarketTest\EndPoint\News */
  protected $newsEndPoint;

  public function __construct(TickerCodeLookup $TCL, Stock $stock, News $News) {
    $this->tickerCodeLookup = $TCL;
    $this->stockEndPoint = $stock;
    $this->newsEndPoint = $News;
  }
  
  public function getCompanyDetail($ticker) {
    $TickerData = $this->tickerCodeLookup->getByTicker($ticker);
    $stockData = $this->stockEndPoint->getByTicker($ticker);
    $newsData = $this->newsEndPoint->getStoryFeedUrl($stockData->storyFeedUrl);
    // Can put caching in here.
    return new CompanyDetail($TickerData, $stockData, $newsData);
  }
}
