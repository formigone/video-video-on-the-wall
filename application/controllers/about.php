<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class About extends Fmg_Controller {

   public function __construct() {
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

      $canonical = $videoService->genCanonical('page', 'about', $this->config->item('base_url') ? : '/');

      $this->setActive('about');
      $this->setTitle('About Easy Learn Tutorial | Free Programming Tutorials');
      $this->setCanonical($canonical);
      $this->setView('scripts/about/index');
      $this->setLayout('layout/bootstrap');

      $this->output->cache(15);
   }
}
