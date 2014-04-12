<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    */
   public function index() {
      $this->load->model('Video_model');
      $this->load->library('Fmg/SomeLib', array($this->Video_model), 'SomeLib');
      /**
       * @type SomeLib $lib
       */
      $lib = $this->SomeLib;

      $msg = $lib->greet('Ro');
      $this->setData('test', $msg);
      $this->setView('simple');
      $this->setLayout('layout/bootstrap');
   }
}
