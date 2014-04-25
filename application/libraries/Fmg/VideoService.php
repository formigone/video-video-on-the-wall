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
    * @return array
    */
   public function listSeries($quality = self::THUMBNAIL_RES_LOW) {
      $res = $this->db->listSeries();
      $qMod = '';

      switch ($quality) {
         case self::THUMBNAIL_RES_MEDIUM:
            $qMod = 'mq';
            break;
         case self::THUMBNAIL_RES_HIGH:
            $qMod = 'hq';
            break;
      }

      if ($quality === self::THUMBNAIL_RES_MEDIUM || $quality === self::THUMBNAIL_RES_HIGH) {
         $filename = 'default.jpg';

         foreach ($res as &$row) {
            $row['img'] = str_replace($filename, $qMod.$filename, $row['img']);
         }
      }

      return $res;
   }

   /**
    * @param string $channel
    * @param int (optional) $max
    *
    * @return array
    */
   public function fetchPlaylists($channel, $max = 3) {
//      $action = 'playlists?part=id%2Csnippet&channelId=UCOmFcwNbdxxRXR6Xza0m4Ew&maxResults=2&fields=pageInfo%2Citems(id%2Csnippet(title%2Cdescription%2Cthumbnails(default)))&key={YOUR_API_KEY}';
      return $this->yt->fetchPlaylists($channel, $max);
   }

   /**
    * @param array $data
    * @param bool $override
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
}
