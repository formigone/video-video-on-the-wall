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
      $urls = $videoService->genSitemap(true);

      header("Content-Type: text/plain charset=UTF-8\r\n");

      foreach ($urls as $url) {
         echo $url, "\n";
      }
   }

   public function atom() {
      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');
      $data = $videoService->genSitemap();

      header('Content-Type: text/xml');

      $this->setData('posts', $data);
      $this->setView('scripts/feed/atom');
      $this->setLayout('layout/clear');
   }

   public function feeds() {
      return $this->atom();
   }
}
