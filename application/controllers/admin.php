<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Fmg_Controller {

   public function __construct() {
      parent::__construct();
   }

   /**
    *
    */
   public function index() {
      if ($this->isLoggedIn()) {
         /**
          * @var VideoService $videoServivce
          */
         $videoService = $this->inj->getService('Video');
         $this->load->library('typography');

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
      $this->gotoIfNotLoggedIn('/admin');

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

   /**
    *
    */
   public function editSeries() {
      $this->gotoIfNotLoggedIn('/admin');

      $this->load->helper('url');
      $this->load->library('typography');

      $id = (int)$this->uri->segment('3', 0);

      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');

      $data = $videoService->listVideoSeries($id);
      $this->setData('series', $data);

      $this->setActive('admin');
      $this->loadSubview('admin', 'scripts/admin/edit');
      $this->setView('scripts/admin/index');
      $this->setLayout('layout/bootstrap');
   }

   /**
    *
    */
   public function syncSeries() {
      $this->gotoIfNotLoggedIn('/admin');

      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');

      $channel = $this->inj->loadKey('/usr/local/ids/youtube-easylearntutorial.id');
      $data = $videoService->fetchPlaylists($channel, 50);

      $videoService->saveSeries($data['items'], false);

      $this->load->helper('url');
      return redirect('/admin');
   }

   /**
    *
    */
   public function syncVideoSeries() {
      $this->gotoIfNotLoggedIn('/admin');

      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');
      $this->load->helper('url');

      $id = $this->input->get('id', 0);
      $alias = $this->input->get('alias', 0);

      $data = $videoService->fetchPlaylistVideos($alias, 50);
      $videoService->saveVideoSeries($id, $alias, $data['items'], false);

      return redirect('/admin');
   }

   /**
    *
    */
   public function updateVideo() {
      $this->gotoIfNotLoggedIn('/admin');

      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');
      $this->load->helper('url');

      $vid = $this->input->post('vid', 0);
      $sid = $this->input->post('sid', 0);

      if ($vid > 0) {
         $this->load->library('security');
         $extra = $this->input->post('extra_description');
         $extra = $this->security->xss_clean($extra);
         $extra = trim($extra);

         $data = array(
            'id' => $vid,
            'extra_description' => $extra
         );

         $videoService->saveVideo($data);
      }

      if ($sid == 0) {
         return redirect('/admin');
      } else {
         return redirect('/admin/editSeries/'.$sid);
      }
   }

   /**
    *
    */
   public function editVideo() {
      $this->gotoIfNotLoggedIn('/admin');

      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');
      $this->load->helper('url');

//      $vid = $this->input->get('vid', 0);
//      $sid = $this->input->get('sid', 0);

      $vid = (int)$this->uri->segment(3, 0);
      $sid = (int)$this->uri->segment(4, 0);

      $data = $videoService->getVideoDetails($vid);
      $this->setData('video', $data);
      $this->setData('sid', $sid);

      $this->setActive('admin');
      $this->loadSubview('admin', 'scripts/admin/edit-video');
      $this->setView('scripts/admin/index');
      $this->setLayout('layout/bootstrap');
   }
}
