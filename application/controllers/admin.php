<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      $this->setActive('admin');
      $this->setTitle('Like a boss');
      $this->setView('scripts/admin/index');
      $this->setLayout('layout/bootstrap');
   }
}
