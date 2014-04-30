<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Series extends Fmg_Controller {

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

      $data = $videoService->listSeries(VideoService::THUMBNAIL_RES_MEDIUM);
      $this->setData('series', $data);

      $this->setActive('series');
      $this->setTitle('Browse by Series | Easy Learn Tutorial');
      $this->setView('scripts/series/index');
      $this->setLayout('layout/bootstrap');
   }

   /**
    *
    */
   public function watch(){
      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');
      $this->load->helper('url');

      $sid = $this->input->get('sid', 0);
      $vid = $this->input->get('vid', 0);

      if ($sid > 0) {
         $data = $videoService->listVideoSeries($sid, VideoService::THUMBNAIL_RES_HIGH);
         $this->setData('series', $data);
      }

      if ($vid > 0) {
         // TODO: get video information
         $video = array();
         $this->setData('video', $video);

         // TOOD: In view, make video playable

         // TODO: Get video resourceId
         // TODO: Add custom description to video
         // TODO: Create video action and view to replace ?sid vs ?vid
         // TODO: In video action/view, add [prev][next] controls
      }

      $this->setActive('series');
      $this->setTitle('Browse by Series | Easy Learn Tutorial');
      $this->setView('scripts/series/watch');
      $this->setLayout('layout/bootstrap');
   }
}
