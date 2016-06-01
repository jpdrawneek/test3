<?php

namespace MergemarketTest\EndPoint;

/**
 * Description of News
 *
 * @author jpd
 */
class News extends GetJson {
  
   public function getStoryFeedUrl($uri) {
    if (filter_var($uri, FILTER_VALIDATE_URL) !== FALSE) {
      $return = $this->doRequest($uri);
      return json_decode($return);
    } else {
      return [];
    }
   }
}
