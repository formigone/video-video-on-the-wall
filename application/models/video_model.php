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

   /**
    * @param int $alias
    *
    * @return array
    */
   public function findSeries($alias) {
      $this->db->select('id');
      $res = $this->db->get_where('series', array('alias' => $alias), 1);

      return array_pop($res->result_array()) ?: array();
   }

   /**
    * @param array $data
    *
    * @return bool
    */
   public function insertSeries(array $data) {
      return $this->db->insert('series', array(
         'alias' => $data['id'],
         'title' => $data['snippet']['title'],
         'description' => $data['snippet']['description'],
         'img' => $data['snippet']['thumbnails']['default']['url']
      ));
   }

   /**
    * @param int $id
    * @param array $data
    *
    * @return bool
    */
   public function updateSeries($id, array $data) {
      $this->db->where('id', $id);

      return $this->db->update('series', array(
            'alias' => $data['id'],
            'title' => $data['snippet']['title'],
            'description' => $data['snippet']['description'],
            'img' => $data['snippet']['thumbnails']['default']['url']
         ));
   }
}
