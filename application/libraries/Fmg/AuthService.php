<?php if (!defined('BASEPATH')) {
   exit('All your direct script access are belong to us');
}

/**
 * Class AuthService
 *
 * @author Rodrigo Silveira
 * Copyright (c) 2014 Formigone.
 */
class AuthService {

   /**
    * @var CI_Session $session
    */
   protected $session;

   const SESS_MAX_ATTEMPTS = 3;
   const SESS_LOCK_TIMEOUT_SEC = 300;

   const SESS_KEY_USER = 'user';
   const SESS_KEY_ATTEMPTS = 'attempts';
   const SESS_KEY_LAST_ATTEMPT = 'last_attempt';
   const SESS_KEY_LOCKED = 'locked';

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
      $user = $this->session->userdata(self::SESS_KEY_USER);

      return !empty($user);
   }

   /**
    * @param string $username
    * @param string $password
    *
    * @return bool
    */
   public function login($username, $password) {
      if (!$this->isLocked()) {
         $this->incAttempts();

         if (!$this->validate($username, $password)) {
            if ($this->tooManyTries()) {
               $this->lock();
            }

            return false;
         }

         $this->resetAttempts();
//         $this->session->set_userdata(self::SESS_KEY_USER, new \Fmg\User(1, $username));
         $this->session->set_userdata(self::SESS_KEY_USER, array('id' => 1, 'username' => $username));

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

   /**
    * @return bool
    */
   protected function isLocked() {
      $locked = (bool)$this->session->userdata(self::SESS_KEY_LOCKED);
      $last = $this->session->userdata(self::SESS_KEY_LAST_ATTEMPT);
      $now = time();

      if ($last === false) {
         return false;
      }

      if ($locked) {
         if ($now - $last > self::SESS_LOCK_TIMEOUT_SEC) {
            $this->unlock();

            return false;
         }

         return true;
      }

      return false;
   }

   /**
    *
    */
   protected function lock() {
      $this->session->set_userdata(self::SESS_KEY_LOCKED, true);
   }

   /**
    *
    */
   protected function unlock() {
      $this->session->unset_userdata(self::SESS_KEY_LOCKED);
      $this->session->set_userdata(self::SESS_KEY_ATTEMPTS, 0);
   }

   /**
    * @return bool
    */
   protected function tooManyTries() {
      $attempts = $this->session->userdata(self::SESS_KEY_ATTEMPTS);

      return $attempts > self::SESS_MAX_ATTEMPTS;
   }

   /**
    *
    */
   protected function incAttempts() {
      $attempts = (int)$this->session->userdata(self::SESS_KEY_ATTEMPTS);
      $this->session->set_userdata(self::SESS_KEY_ATTEMPTS, ++$attempts);
      $this->session->set_userdata(self::SESS_KEY_LAST_ATTEMPT, time());
   }

   /**
    *
    */
   protected function resetAttempts() {
      $this->session->set_userdata(self::SESS_KEY_ATTEMPTS, 0);
   }

   /**
    * @param string $username
    * @param string $password
    *
    * @return bool
    */
   protected function validate($username, $password) {
      return $username == 'user' && $password == 'password';
   }
}
