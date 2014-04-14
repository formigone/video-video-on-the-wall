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
      $this->load->library('Fmg/AuthService', array($this->session), 'AuthService');

      /**
       * @var AuthService $AuthService
       */
      $AuthService = $this->AuthService;

      $this->setActive('admin');

      if ($AuthService->isLoggedIn()) {
         $this->setTitle('Welcome, Master!');
      } else {
         $this->setTitle('Easy Learn Tutorial: Admin Dash');
      }

      $AuthService->login('rokko', '123');
var_dump($AuthService->getUser());exit;
      $this->setData('user', $AuthService->getUser());
      $this->setView('scripts/admin/index');
      $this->setLayout('layout/bootstrap');
   }
}
