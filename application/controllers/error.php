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
      $this->setTitle('What if I told you... stop breaking Easy Learn Tutorial!');
      $this->setView('404');
      $this->setLayout('layout/bootstrap');

      log_message('error', '404: '.$_SERVER['REQUEST_URI']);
   }

   public function e_500(){
      exit("error 500!");
   }
}
