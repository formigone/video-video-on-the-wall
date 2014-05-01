<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tutorial extends Fmg_Controller {

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
      $this->load->helper('url');

      $vid = $this->uri->segment(3);

      $data = $videoService->getVideoDetails($vid);
      $this->setData('video', $data);

      $title = $data['meta_title'] ?: $data['title'].' | '. $data['series']['title'];

      $this->setActive('series');
      $this->setTitle($title);
      $this->setView('scripts/tutorial/index');
      $this->setLayout('layout/bootstrap');

      $this->output->cache(5);
   }

   /**
    *
    */
   public function video(){
      return $this->index();
   }
}
