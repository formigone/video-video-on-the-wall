<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Error extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      $this->output->set_status_header('404');
      $this->setView('404');
      $this->setLayout('layout/bootstrap');
   }

   public function e_500(){
      exit("error 500!");
   }
}
