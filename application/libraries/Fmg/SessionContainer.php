<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

require_once('User.php');

/**
 * Class SessionContainer
 *
 * @author Rodrigo Silveira
 * Copyright (c) 2014 Formigone.
 */
class SessionContainer {

   /**
    * @var CI_Session $session
    */
   protected $session;

   const SESS_KEY_USER = 'user';

   /**
    * @param array $params
    */
   public function __construct(array $params) {
      $this->session = $params[0];
   }

   /**
    * @return bool
    */
   public function isLoggedIn() {
      return $this->session->userdata('user');
   }

   /**
    * @param string $username
    * @param string $password
    *
    * @return bool
    */
   public function login($username, $password) {
      $this->session->unset_userdata(self::SESS_KEY_USER);
      if (!empty($username) && !empty($password)) {
         $this->session->set_userdata(
            array(
               self::SESS_KEY_USER => new \Fmg\User(1, 'rokko')
            )
         );

         return true;
      }

      return false;
   }

   /**
    * @return void
    */
   public function logout() {
      return $this->session->sess_destroy();
   }

   /**
    * @return string
    */
   public function getUser() {
      return $this->session->userdata(self::SESS_KEY_USER);
   }
}
