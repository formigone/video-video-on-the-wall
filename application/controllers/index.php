<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Fmg_Controller {

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

      $series = array(
         array(
            'title' => 'Google Web Toolkit',
            'href' => '/series/watch/37/gwt-tutorials:-google-web-toolkit'
         ),array(
            'title' => 'JavaScript for Beginners',
            'href' => '/series/watch/29/javascript-for-beginners'
         ),array(
            'title' => 'PHP Design Patterns',
            'href' => '/series/watch/36/php-programming-design-patterns'
         ),array(
            'title' => 'Nintendo Game Development',
            'href' => '/series/watch/28/nintendo-game-development'
         ),
      );

      $canonical = trim($this->config->item('base_url'), '/') ?: '/';

      $this->setData('series', $series);
      $this->setData('latest', $videoService->listLatestVideos(6, VideoService::THUMBNAIL_RES_HIGH));

      $this->setActive('home');
      $this->setTitle('Easy Learn Tutorial | Free Programming Lessons');
      $this->setCanonical($canonical);
      $this->setView('scripts/index/index');
      $this->setLayout('layout/bootstrap');

      $this->output->cache(5);
   }
}
