<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      $this->load->model('Video_model');
      $this->load->library('Fmg/VideoService', array($this->Video_model), 'VideoService');
      /**
       * @type VideoService $lib
       */
      $lib = $this->VideoService;

      $this->setData('series', $lib->getMockSeries());
      $this->setActive('home');
      $this->setView('home');
      $this->setLayout('layout/bootstrap');
   }
}
