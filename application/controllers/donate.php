<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Donate extends Fmg_Controller {

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

      $canonical = $videoService->genCanonical('page', 'donate', $this->config->item('base_url') ? : '/');

      $this->setActive('donate');
      $this->setTitle('Donate to support Easy Learn Tutorial | Free Programming Tutorials');
      $this->setCanonical($canonical);
      $this->setView('scripts/donate/index');
      $this->setLayout('layout/bootstrap');

      $this->output->cache(15);
   }
}
