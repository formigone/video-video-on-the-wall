<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

   protected $view;

   public function __construct(){
      parent::__construct();

      $this->view = array(
         'page' => array(
            'title' => 'Easy Learn Tutorial: Free Programming Lessons'
         ),
         'data' => array()
      );
   }

   protected function setData($key, $val) {
      $this->view['data'][$key] = $val;
   }

   protected function setTitle($title) {
      $this->view['page']['title'] = $title;
   }

   protected function setView($view) {
      $this->load->view($view, $this->view);
   }

   /**
    */
   public function index() {
      $this->setData('test', array(1, 2, 3));
      $this->setView('layout/bootstrap');
   }
}
