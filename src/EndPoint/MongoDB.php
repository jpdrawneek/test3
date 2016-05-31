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


  public function getItems() {
    $output = [];
    foreach ($this->collection->find() AS $data) {
      $output[] = new TickerCode($data['company'], $data['TickerCode']);
    }
    return $output;
  }

}
