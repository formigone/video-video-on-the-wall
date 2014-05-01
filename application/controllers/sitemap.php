<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');
      $urls = $videoService->genSitemap();

      header("Content-Type: text/plain charset=UTF-8\r\n");

      foreach ($urls as $url) {
         echo $url, "\n";
      }
   }
}
