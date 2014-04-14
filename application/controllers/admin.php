<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      $this->load->library('session');
      $this->load->library('Fmg/SessionContainer', array($this->session), 'SessionContainer');

      /**
       * @var SessionContainer $sessionContainer
       */
      $sessionContainer = $this->SessionContainer;

      $this->setActive('admin');

      if ($sessionContainer->isLoggedIn()) {
         $this->setTitle('Welcome, Master!');
      } else {
         $this->setTitle('Easy Learn Tutorial: Admin Dash');
      }

      $sessionContainer->login('rokko', '123');
var_dump($sessionContainer->getUser());exit;
      $this->setData('user', $sessionContainer->getUser());
      $this->setView('scripts/admin/index');
      $this->setLayout('layout/bootstrap');
   }
}
