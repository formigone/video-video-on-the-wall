<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

class SomeLib {

   /**
    * @var Video_model $db
    */
   protected $db;

   public function __construct($params){
      $this->db = $params[0];
   }

   public function greet($name) {
      return sprintf('%s, %s', $this->db->getGreeting(), $name);
   }
}
