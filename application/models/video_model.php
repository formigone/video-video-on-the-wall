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
         select * from series order by title asc
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
            'created' => $data['snippet']['publishedAt'],
            'resource_id' => $data['snippet']['resourceId']['videoId']
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
            'img' => $data['snippet']['thumbnails']['default']['url'],
            'resource_id' => $data['snippet']['resourceId']['videoId']
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
    * @param bool (optional) $byDate
    *
    * @return array
    */
   public function listVideoSeries($id, $byDate = false) {
      $id = (int)$id;
      $order = $byDate ? 'order by v.created desc' : 'order by vs.seq';

      return $this->db->query('
         select v.created, s.title as series_title, s.id as series_id, v.id, v.title, v.img, v.alias, if(v.extra_description = "", v.description, v.extra_description) as description,
         v.description as raw_description, v.extra_description as raw_extra_description,
         m.title as meta_title
         from video_series vs
         join video v on v.id = vs.video_id
         join series s on s.id = vs.series_id
         left join video_meta m on m.video_id = v.id
         where vs.series_id = ' . $id . '
         group by vs.video_id '.$order)->result_array();
   }

   /**
    * @param int $max
    *
    * @return array
    */
   public function listLatestVideos($max) {
      $max = (int)$max;

      return $this->db->query('
         select v.id, v.title, v.img, s.id as series_id
         from video v
         join video_series vs on vs.video_id = v.id
         join series s on vs.series_id = s.id
         group by v.id
         order by created desc
         limit ' . $max
      )->result_array();
   }

   /**
    * @param int $id
    *
    * @return array
    */
   public function getVideoDetails($id) {
      $id = (int)$id;

      $res = $this->db->query('
         select v.id, v.title, v.created, v.resource_id, if(v.extra_description = "", v.description, v.extra_description) as extra_description,
         s.title as series_title, s.id as series_id,
         vs.seq,
         m.title as meta_title
         from video v
         join video_series vs on vs.video_id = v.id
         join series s on vs.series_id = s.id
         left join video_meta m on m.video_id = v.id
         where v.id = ' . $id
      )->result_array();

      return array_pop($res) ? : array();
   }

   /**
    * @param int $id
    *
    * @return array
    */
   public function getSeriesDetails($id) {
      $id = (int)$id;

      $this->db->select('id, title');
      $res = $this->db->get_where('series', array('id' => $id), 1);

      return array_pop($res->result_array()) ? : array();
   }

   /**
    * @param int $series
    * @param int $id
    *
    * @return array
    */
   public function getNext($series, $id) {
      $id = (int)$id;
      $series = (int)$series;

      $res = $this->db->query('
         select v.id, v.title, v.created,
         vs.seq
         from video v
         join video_series vs on vs.video_id = v.id
         join series s on vs.series_id = s.id
         where v.id > '.$id.' and s.id = '.$series.'
         order by vs.seq asc limit 1
      ')->result_array();

      return array_pop($res) ? : array();
   }

   /**
    * @param int $series
    * @param int $id
    *
    * @return array
    */
   public function getPrevious($series, $id) {
      $id = (int)$id;
      $series = (int)$series;

      $res = $this->db->query('
         select v.id, v.title, v.created,
         vs.seq
         from video v
         join video_series vs on vs.video_id = v.id
         join series s on vs.series_id = s.id
         where v.id < '.$id.' and s.id = '.$series.'
         order by vs.seq desc limit 1
      ')->result_array();

      return array_pop($res) ? : array();
   }

   /**
    * @param array $data
    *
    * @return bool
    */
   public function saveVideo(array $data){
      $this->db->where('id', $data['id']);
      unset($data['id']);

      return $this->db->update('video', $data);
   }

   /**
    * @param array $data
    *
    * @return bool
    */
   public function saveVideoMeta(array $data){
      $this->db->set('video_id', $data['video_id']);
      $this->db->set('title', $data['title']);

      $res = $this->db->get_where('video_meta', array('video_id' => $data['video_id']), 1);

      if ($res->num_rows()) {
         return $this->db->update('video_meta');
      } else {
         return $this->db->insert('video_meta');
      }
   }

   /**
    * @param array $data
    *
    * @return bool
    */
   public function saveSeries(array $data){
      $this->db->where('id', $data['id']);
      unset($data['id']);

      return $this->db->update('series', $data);
   }
}
