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
      $this->setTitle('Programming Videos | Browse by Series | Easy Learn Tutorial');
      $this->setView('scripts/series/index');
      $this->setLayout('layout/bootstrap');

      $this->output->cache(5);
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

      $sid = (int)$this->uri->segment(3);

      if ($sid > 0) {
         $data = $videoService->listVideoSeries($sid, VideoService::THUMBNAIL_RES_HIGH);
         $this->setData('series', $data);
      }

      $canonical = $videoService->genCanonical('series', $sid, $this->config->item('base_url') ?: '/');

      $ct = count($data['videos']);
      $this->setActive('series');
      $this->setTitle($data['title'].' | '. $ct. ' video'. ($ct != 1 ? 's':''). ' in series | Easy Learn Tutorial');
      $this->setCanonical($canonical);
      $this->setView('scripts/series/watch');
      $this->setLayout('layout/bootstrap');

      $this->output->cache(5);
   }
}
