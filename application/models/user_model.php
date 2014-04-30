<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

class User_model extends CI_Model {
   public function __construct() {
      parent::__construct();

      $this->load->database();
   }

   /**
    * @param string $username
    *
    * @return array
    */
   public function findByUsername($username) {
      $this->db->select(array('id', 'salt', 'password'));
      $res = $this->db->get_where('user', array('username' => $username), 1);

      return array_pop($res->result_array()) ?: array();
   }
}
