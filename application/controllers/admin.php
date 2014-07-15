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

   public function playlistDump() {
      $data = file_get_contents('/tmp/youtube-dump.json');
      $data = json_decode($data, true);
      foreach ($data['items'] as $item) {
         if($item['snippet']['title'][0] != ':') {
            var_dump($item);
         }
      }
      exit;
   }

   /**
    *
    */
   public function grabFromYoutube() {
      $this->gotoIfNotLoggedIn('/admin');

      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');

      $channel = $this->inj->loadKey('/usr/local/ids/youtube-easylearntutorial.id');
      $data = $videoService->fetchPlaylists($channel, 50);

      echo json_encode($data);exit;
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

//      $file = file_get_contents('/tmp/youtube-pl-dump.json');
//      if (!empty($file)) {
//         $data = json_decode($file, true);
//      }

      if (empty($data)) {
         $channel = $this->inj->loadKey('/usr/local/ids/youtube-easylearntutorial.id');
         $data = $videoService->fetchPlaylists($channel, 5);
      }

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

      $vid = (int)$this->input->post('vid', 0);
      $sid = (int)$this->input->post('sid', 0);

      if ($vid > 0) {
         $this->load->library('security');
         $extra = $this->input->post('extra_description');
         $extra = $this->security->xss_clean($extra);
         $extra = trim($extra);

         $title = $this->input->post('meta_title');
         $title = $this->security->xss_clean($title);
         $title = trim($title);

         $data = array(
            'id' => $vid,
            'extra_description' => $extra
         );

         $meta = array(
            'video_id' => $vid,
            'title' => $title
         );

         $videoService->saveVideo($data);
         $videoService->saveVideoMeta($meta);
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

   public function cleanInBulk() {
      exit('off');
      /**
       * @var VideoService $videoServivce
       */
      $videoService = $this->inj->getService('Video');
      $res = $videoService->removeByRegex(array("\n\n"), '');
      $res = $videoService->removeByRegex(
         array(
            'Copyright (c) 2013 Rodrigo Silveira http://www.easylearntutorial.com',
            '--------------------------------
Other links of interest
--------------------------------',
            '-- http://www.easylearntutorial.com Our official websites. Check out for more text and video tutorials, updates, and upcoming tutorial articles and events.',
            "-- http://www.facebook.com/easylearntutorialonline Join us on Facebook and share our computer programming tutorials and how to's with your friends. Social learning is not only easy learning, but fun learning.",
            '-- http://www.twitter.com/easylearntuts Follow us on Twitter to receive the latest news and updates from us, as well as other relevant and interesting links to other useful software-related tutorials, classes, and lessons.',
            '-- Our YouTube channel http://www.youtube.com/user/easylearntutorial ',
            '-- Visit our website http://www.easylearntutorial.com for more text and video tutorials, updates, and upcoming tutorial articles and events',
            '-- Like us on Facebook http://www.facebook.com/easylearntutorialonline',
            '-- Follow us on Twitter http://www.twitter.com/easylearntuts',
            'For more HTML 5 tutorial videos, check out the complete playlist at http://www.youtube.com/playlist?list=PLGJDCzBP5j3xua7wZxIN-AJGvIwPdZ_eX',
            'Other links of interest:',
            '=====================',
            '----------------------------------
Complete Source Code
----------------------------------',
            'The complete source code for the computer programming challenge: tic tac toe edition is found at https://github.com/formigone/tictactoe-challenge',
            'For more information about my programming challenge, checkout my GitHub repository at http://github.com/formigone/tictactoe-challenge to access the complete source code for this programming series.',
            '============',
            'Submit your best times by posting a comment in any one of the tutorial videos.',
            '* * * * * * * * * * * * * * * * * * * *
http://www.rodrigo-silveira.com
* * * * * * * * * * * * * * * * * * * *',
            'Other links of interest:',
'-- Our YouTube channel http://www.youtube.com/user/easylearntutorial',
'-- Visit our website http://www.easylearntutorial.com for more text and video tutorials, updates, and upcoming tutorial articles and events',
'-- Like us on Facebook http://www.facebook.com/easylearntutorialonline',
'- Follow us on Twitter http://www.twitter.com/easylearntuts'
         ), ''
      );
//      var_dump($res);
   }
}
