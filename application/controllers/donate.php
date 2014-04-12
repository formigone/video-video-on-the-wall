<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Donate extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      $this->setActive('donate');
      $this->setTitle('Donate to support Easy Learn Tutorial | Free Programming Tutorials');
      $this->setView('scripts/donate/index');
      $this->setLayout('layout/bootstrap');
   }
}
