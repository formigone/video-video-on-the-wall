<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

class Video_model extends CI_Model {
   public function __construct(){
      parent::__construct();
   }

   public function getGreeting(){
      return 'Hello!!';
   }
}
