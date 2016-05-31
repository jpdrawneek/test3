<?php

namespace MergemarketTest\EndPoint;

/**
 * Description of News
 *
 * @author jpd
 */
class News extends GetJson {
  
   public function getStoryFeedUrl($uri) {
     $return = $this->doRequest($uri);
     return json_decode($return);
   }
}
