<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

   protected $view;

   public function __construct(){
      parent::__construct();

      $this->view = array(
         'page' => array(
            'title' => 'Easy Learn Tutorial: Free Programming Lessons'
         ),
         'data' => array(),
         'view' => false
      );
   }

   protected function setData($key, $val) {
      $this->view['data'][$key] = $val;
   }

   protected function setTitle($title) {
      $this->view['page']['title'] = $title;
   }

   protected function setView($view) {
      $this->view['view'] = $view;
   }

   protected function setLayout($view) {
      $this->load->view($view, $this->view);
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
