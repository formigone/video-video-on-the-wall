<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

/**
 * Class Youtube
 *
 * @author Rodrigo Silveira
 * Copyright (c) 2014 Formigone.
 */
class YoutubeService {

   const URL = 'https://www.googleapis.com/youtube/v3/';
   const ACTION_PLAYLIST = 'playlists';

   /** @var string $key */
   protected $key;

   /**
    * @param array $params
    */
   public function __construct(array $params){
      $this->key = $params[0];
   }

   /**
    * @param string $channel
    *
    * @return array
    */
   public function listPlaylists($channel){
      'https://www.googleapis.com/youtube/v3/';
      $action = 'playlists?part=id%2Csnippet&channelId=UCOmFcwNbdxxRXR6Xza0m4Ew&maxResults=2&fields=pageInfo%2Citems(id%2Csnippet(title%2Cdescription%2Cthumbnails(default)))&key={YOUR_API_KEY}';

      $cmd = 'https://www.googleapis.com/youtube/v3/playlists?part=id%2Csnippet&channelId='.$channel.'&maxResults=3&key='.$key;
      $ch = curl_init($cmd);

      $resp = curl_exec($ch);
      curl_close($ch);

      return json_decode($resp, true);
   }

   /**
    * @param string $action
    * @param string $parts
    * @param string $fields
    * @param int $max
    *
    * @return string
    */
   protected function buildUrl($action, $parts, $fields, $max) {
      return '';
   }

   /**
    * @param string $filename
    *
    * @return string
    */
   public function loadKey($filename) {
      $data = file_get_contents($filename);
      $data = str_replace('\n', '', $data);

      return trim($data);
   }
}
