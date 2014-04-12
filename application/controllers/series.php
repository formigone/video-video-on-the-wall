<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Series extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      $this->setActive('series');
      $this->setTitle('Browse by Series | Easy Learn Tutorial');
      $this->setView('scripts/series/index');
      $this->setLayout('layout/bootstrap');
   }
}
