<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

/**
 * Class Fmg_Controller
 *
 * @author Rodrigo Silveira
 * Copyright (c) 2014 Formigone.
 */
class Fmg_Controller extends CI_Controller {
   /**
    * @var array Values to be sent to layouts and views
    */
   protected $view;

   /**
    *
    */
   public function __construct() {
      parent::__construct();

      $this->view = array(
         'page' => array(
            'title' => 'Powered by Formigone',
            'active' => ''
         ),
         'data' => array(),
         'view' => false
      );
   }

   /**
    * Data to be sent to layout and views
    *
    * @param string $key
    * @param mixed $val
    */
   protected function setData($key, $val) {
      $this->view['data'][$key] = $val;
   }

   /**
    * @param string $page Page type to mark active on main nav
    */
   protected function setActive($page) {
      $this->view['page']['active'] = $page;
   }

   /**
    * @param string $title Text to be set in document's <title> tag
    */
   protected function setTitle($title) {
      $this->view['page']['title'] = $title;
   }

   /**
    * @param string $view Path to some view file
    */
   protected function setView($view) {
      $this->view['view'] = $view;
   }

   /**
    * @param $view Path to some view file containing sub-views
    */
   protected function setLayout($view) {
      $this->load->view($view, $this->view);
   }
}
