<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Fmg_Controller {

   public function __construct() {
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

      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');

      if ($authService->isLoggedIn()) {
         $series = $videoService->listSeries();
         $this->setTitle('Welcome, Master!');
         $this->setData('series', $series);
         $this->loadSubview('admin', 'scripts/admin/dash');
      } else {
         $this->setTitle('Easy Learn Tutorial: Admin Dash');
         $this->loadSubview('admin', 'scripts/admin/login');
      }

      $this->setActive('admin');
      $this->setView('scripts/admin/index');
      $this->setLayout('layout/bootstrap');
   }

   /**
    *
    */
   public function logout() {
      $this->load->helper('url');

      /**
       * @var AuthService $authService
       */
      $authService = $this->inj->getService('Auth');
      $authService->logout();

      redirect('/admin');
   }

   /**
    *
    */
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

   /**
    *
    */
   public function addSeries() {
      /**
       * @var AuthService $authService
       */
      $authService = $this->inj->getService('Auth');

      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');

      if ($authService->isLoggedIn()) {
         $this->setTitle('Add Series');
         $this->loadSubview('admin', 'scripts/admin/addSeries');
      } else {
         $this->load->helper('url');

         return redirect('/admin');
      }

      $this->setActive('admin');
      $this->setView('scripts/admin/index');
      $this->setLayout('layout/bootstrap');
   }

   public function pull() {
      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');

      $key = $videoService->loadKey('/usr/local/keys/youtube-api.key');
      $channel = $videoService->loadKey('/usr/local/ids/youtube-easylearntutorial.id');
      $data = $videoService->apiCall($key, $channel);

      var_dump($data);exit;

      $this->setActive('admin');
      $this->setLayout('layout/bootstrap');
   }

   public function callback(){
      
   }
}
