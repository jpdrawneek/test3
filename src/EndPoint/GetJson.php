<?php

namespace MergemarketTest\EndPoint;

/**
 * Description of GetJson
 *
 * @author jpd
 */
abstract class GetJson {

  protected function doRequest($url) {
    // @todo Look at abstracting this out to the DI container to make it swappable.
    $client = new \GuzzleHttp\Client();
    $res = $client->request('GET', $url);
    // @todo Handle errors in this class.
    if( $res->getStatusCode() == 200) {
      return $res->getBody();
    } else {
      throw new Exception('Need to handle none 200 responses.');
    }
  }

}
