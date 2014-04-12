<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class About extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      $this->setActive('about');
      $this->setTitle('About Easy Learn Tutorial | Free Programming Tutorials');
      $this->setView('scripts/about/index');
      $this->setLayout('layout/bootstrap');
   }
}
