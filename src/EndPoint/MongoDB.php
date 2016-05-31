<?php

namespace MergemarketTest\EndPoint;

use MergemarketTest\Data\TickerCode as TickerCode;

/**
 * Description of MongoDB
 *
 * @author jpd
 */
class MongoDB implements TickerEndPoint {
  /** @var \MongoDB\Client */
  protected $connection;
  /** @var \MongoDB\Database */
  protected $db;
  /** @var \MongoDB\Collection */
  protected $collection;

  public function __construct($uri, $collection) {
    list($scheme, $blank, $server, $database) = split('/', $uri);
    if (!(strlen($database) > 0)) {
      throw new Exception('Database not set in configuration uri');
    }
    $this->connection = new \MongoDB\Client($uri);
    $this->db = $this->connection->$database;
    $this->collection = $this->db->$collection;
  }


  public function getItems($filter = []) {
    $output = [];
    foreach ($this->collection->find($filter) AS $data) {
      $output[] = new TickerCode($data['name'], $data['tickerCode']);
    }
    return $output;
  }
  /**
   * 
   * @param String $ticker
   * @return TickerCode
   */
  public function getByTicker($ticker) {
    $result = $this->getItems(['tickerCode' => $ticker]);
    $output = array_shift($result);
    return $output;
  }

}
