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
      '
      )->result_array();
   }

   /**
    * @param int $alias
    *
    * @return array
    */
   public function findSeries($alias) {
      $this->db->select('id');
      $res = $this->db->get_where('series', array('alias' => $alias), 1);

      return array_pop($res->result_array()) ? : array();
   }

   /**
    * @param int $alias
    *
    * @return array
    */
   public function findVideo($alias) {
      $this->db->select('id');
      $res = $this->db->get_where('video', array('alias' => $alias), 1);

      return array_pop($res->result_array()) ? : array();
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
         )
      );
   }

   /**
    * @param array $data
    *
    * @return bool
    */
   public function insertVideo(array $data) {
      return $this->db->insert('video', array(
            'alias' => $data['id'],
            'title' => $data['snippet']['title'],
            'description' => $data['snippet']['description'],
            'img' => $data['snippet']['thumbnails']['default']['url'],
            'created' => $data['snippet']['publishedAt']
         )
      );
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
         )
      );
   }

   /**
    * @param int $id
    * @param array $data
    *
    * @return bool
    */
   public function updateVideo($id, array $data) {
      $this->db->where('id', $id);

      return $this->db->update('video', array(
            'alias' => $data['id'],
            'title' => $data['snippet']['title'],
            'description' => $data['snippet']['description'],
            'img' => $data['snippet']['thumbnails']['default']['url']
         )
      );
   }

   /**
    * @param string $videoAlias
    * @param string $seriesAlias
    * @param int $seriesId
    * @param int $seq
    *
    * @return mixed
    */
   public function addVideoToSeries($videoAlias, $seriesAlias, $seriesId, $seq) {
      $video = array_pop(
         $this->db->query('select id from video where alias = "' . $videoAlias . '" limit 1')->result_array()
      ) ? : array();
      $series = array_pop(
         $this->db->query('select id from series where alias = "' . $seriesAlias . '" and id = ' . $seriesId . ' limit 1')->result_array()
      ) ? : array();

      // Not the most elegant solution, but CI inserts records twice if db->query(insert) has a subquery in it to locate some FK...
      return $this->db->insert('video_series', array(
            'video_id' => $video['id'],
            'series_id' => $series['id'],
            'seq' => $seq
         )
      );
   }

   /**
    * @param int $id
    *
    * @return array
    */
   public function listVideoSeries($id){
      $id = (int)$id;
      $res = $this->db->query('
         select s.title as series_title, s.id as series_id, v.*
         from video_series vs
         join video v on v.id = vs.video_id
         join series s on s.id = vs.series_id
         where vs.series_id = '.$id.'
         group by vs.video_id
         order by vs.seq
      ');

      return $res->result_array();
   }

   /**
    * @param int $max
    *
    * @return array
    */
   public function listLatestVideos($max){
      $max = (int)$max;

      return $this->db->query('
         select v.id, v.title, v.img, s.id as series_id
         from video v
         join video_series vs on vs.video_id = v.id
         join series s on vs.series_id = s.id
         order by created desc
         limit '.$max
      )->result_array();
   }
}
