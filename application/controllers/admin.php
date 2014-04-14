<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Fmg_Controller {

   public function __construct(){
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      /**
       * @var AuthService $authService
       */
      $authService = $this->inj->getService('Auth');

      if ($authService->isLoggedIn()) {
         $this->setTitle('Welcome, Master!');
      } else {
         $this->setTitle('Easy Learn Tutorial: Admin Dash');
      }

      $this->setData('user', $authService->getUser());
      $this->setActive('admin');
      $this->setView('scripts/admin/index');
      $this->setLayout('layout/bootstrap');
   }

   public function logout(){
      $this->load->helper('url');

      /**
       * @var AuthService $authService
       */
      $authService = $this->inj->getService('Auth');
      $authService->logout();

      redirect('/admin');
   }

   public function login() {
      /**
       * @var AuthService $authService
       */
      $authService = $this->inj->getService('Auth');
      $this->load->helper('url');

      $post = $this->input->post();

      if (!empty($post)) {
         $authService->login($post['user'], $post['password']);
      }

      return redirect('/admin');
   }
}
