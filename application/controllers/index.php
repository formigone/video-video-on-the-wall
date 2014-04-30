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
            'href' => '/series/watch/?st=gwt-tutorials:-google-web-toolkit&sid=37'
         ),array(
            'title' => 'JavaScript for Beginners',
            'href' => '/series/watch/?st=javascript-for-beginners&sid=29'
         ),array(
            'title' => 'PHP Design Patterns',
            'href' => '/series/watch/?st=php-programming-design-patterns&sid=36'
         ),array(
            'title' => 'Nintendo Game Development',
            'href' => '/series/watch/?st=nintendo-game-development&sid=28'
         ),
      );

      $this->setData('series', $series);
      $this->setData('latest', $videoService->listLatestVideos(6, VideoService::THUMBNAIL_RES_HIGH));

      $this->setActive('home');
      $this->setTitle('Easy Learn Tutorial | Free Programming Lessons');
      $this->setView('scripts/index/index');
      $this->setLayout('layout/bootstrap');

      $this->output->cache(5);
   }
}
