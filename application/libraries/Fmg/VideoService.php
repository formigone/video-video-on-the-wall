<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

/**
 * Class VideoService
 *
 * @author Rodrigo Silveira
 * Copyright (c) 2014 Formigone.
 */
class VideoService {

   const THUMBNAIL_RES_LOW = 0;
   const THUMBNAIL_RES_MEDIUM = 1;
   const THUMBNAIL_RES_HIGH = 2;

   /**
    * @var Video_model $db
    */
   protected $db;

   /**
    * @var YoutubeService $yt
    */
   protected $yt;

   /**
    * @param array $params
    */
   public function __construct(array $params) {
      $this->db = $params[0];
      $this->yt = $params[1];
   }

   /**
    * @param int (optional) $quality
    *
    * @return array
    */
   public function listSeries($quality = self::THUMBNAIL_RES_LOW) {
      $res = $this->db->listSeries();
      $res = $this->processVideoSeriesList($res, $quality);

      return $res;
   }

   /**
    * @param string $channel
    * @param int (optional) $max
    *
    * @return array
    */
   public function fetchPlaylists($channel, $max = 3) {
      return $this->yt->fetchPlaylists($channel, $max);
   }

   /**
    * @param array $data
    * @param bool (optional) $override
    *
    * @return bool
    */
   public function saveSeries(array $data, $override = false) {
      $status = true;

      foreach ($data as $series) {
         $_series = $this->db->findSeries($series['id']);

         if (empty($_series)) {
            if (!$this->db->insertSeries($series)) {
               $status = false;
            }
         } else {
            if ($override) {
               $this->db->updateSeries($_series['id'], $series);
            }
         }
      }

      return $status;
   }

   /**
    * @param int $id
    * @param string $alias
    * @param array $data
    * @param bool (optional) $override
    *
    * @return bool
    */
   public function saveVideoSeries($id, $alias, array $data, $override = false) {
      $status = true;

      foreach ($data as $video) {
         $_video = $this->db->findVideo($video['id']);

         if (empty($_video)) {
            if (!$this->db->insertVideo($video)) {
               $status = false;
               continue;
            }
         } else {
            if ($override) {
               $this->db->updateVideo($_video['id'], $video);
            }
         }

         $this->db->addVideoToSeries($video['id'], $alias, $id, $video['snippet']['position']);
      }

      return $status;
   }

   /**
    * @param int $alias
    * @param int (optional) $max
    *
    * @return array
    */
   public function fetchPlaylistVideos($alias, $max = 3) {
      return $this->yt->fetchPlaylistVideos($alias, $max);
   }

   /**
    * @param int $id
    * @param int (optional) $quality
    *
    * @return array
    */
   public function listVideoSeries($id, $quality = self::THUMBNAIL_RES_LOW) {
      $res = $this->db->listVideoSeries($id);
      $data = array(
         'id' => $res[0]['series_id'],
         'title' => $res[0]['series_title'],
         'videos' => $res
      );

      $data['videos'] = $this->processVideoSeriesList($data['videos'], $quality);

      return $data;
   }

   protected function processVideoSeriesList(array &$data, $quality, array $keys = array()){
      if (empty($keys)) {
         $keys = array(
            'img' => 'img',
            'title' => 'title'
         );
      }

      foreach ($data as &$row) {
         $row['img'] = $this->getImageUrl($row[$keys['img']], $quality);
         $row['clean-title'] = $this->cleanTitle($row[$keys['title']]);
         $row['title'] = $row[$keys['title']];
      }

      return $data;
   }

   protected function getImageUrl($img, $quality) {
      $qMod = '';
      $filename = 'default.jpg';

      switch ($quality) {
         case self::THUMBNAIL_RES_MEDIUM:
            $qMod = 'mq';
            break;
         case self::THUMBNAIL_RES_HIGH:
            $qMod = 'hq';
            break;
      }

      return str_replace($filename, $qMod . $filename, $img);
   }

   protected function cleanTitle($title) {
      $title = strtolower(trim($title));
      $title = str_replace(array('&', ':', '?', '!'), '', $title);
      $title = preg_replace('/\s+/', '-', $title);
      $title = preg_replace('/--+/', '-', $title);

      return $title;
   }

   /**
    * @param int $max
    * @param int $quality
    *
    * @return array
    */
   public function listLatestVideos($max = 3, $quality = self::THUMBNAIL_RES_LOW) {
      $res = $this->db->listLatestVideos($max);

      $data = array(
         'series' => array('id' => $res[0]['series_id']),
         'videos' => $this->processVideoSeriesList($res, $quality)
      );

      return $data;
   }
}
