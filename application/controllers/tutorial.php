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

      $vid = $this->input->get('vid', 0);

      $data = $videoService->getVideoDetails($vid);
      $this->setData('video', $data);

      $this->setActive('series');
      $this->setTitle($data['title'].' | Easy Learn Tutorial');
      $this->setView('scripts/tutorial/index');
      $this->setLayout('layout/bootstrap');
   }
}
