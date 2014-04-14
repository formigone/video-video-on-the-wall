<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

class Video_model extends CI_Model {
   public function __construct() {
      parent::__construct();

      $this->load->database();
   }

   /**
    * @return array
    */
   public function listSeries() {
      return $this->db->query('
         select * from series order by alias
      ')->result_array();
   }
}
