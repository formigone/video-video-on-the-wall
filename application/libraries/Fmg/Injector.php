<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

require_once('User.php');

/**
 * Class Injector
 *
 * @author Rodrigo Silveira
 * Copyright (c) 2014 Formigone.
 */
class Injector {

   protected $services;

   public function __construct() {
      $this->services = array();
   }

   /**
    * Lazily constructs and returns services. If the injector doesn't know how to construct the service, returns null
    * 
    * @param string $service
    *
    * @return mixed
    */
   public function getService($service) {
      if (array_key_exists($service, $this->services)) {
         return $this->services[$service];
      }

      $meth = 'make'.ucfirst($service);

      if (method_exists($this, $meth)) {
         return $this->$meth($service);
      }

      return null;
   }

   /**
    * @param string $service
    * @return AuthService $AuthService
    */
   protected function makeAuth($service){
      $CI =& get_instance();
      $CI->load->library('session');
      $CI->load->library('Fmg/AuthService', array($CI->session), 'AuthService');

      $this->services[$service] = $CI->AuthService;

      return $CI->AuthService;
   }
}
