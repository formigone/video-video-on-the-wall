<?php if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

/**
 * Class VideoService
 *
 * @author Rodrigo Silveira
 * Copyright (c) 2014 Formigone.
 */
class VideoService {

   /**
    * @var Video_model $db
    */
   protected $db;

   /**
    * @param array $params
    */
   public function __construct(array $params){
      $this->db = $params[0];
   }

   /**
    * @return array
    */
   public function listSeries() {
      return $this->db->listSeries();
   }

   /**
    *
    */
   public function testDb(){
      return $this->db->testDb();
   }

   /**
    * @param string $key
    * @param string $channel
    *
    * @return array
    */
   public function listPlaylists($key, $channel){
      $action = 'playlists?part=id%2Csnippet&channelId=UCOmFcwNbdxxRXR6Xza0m4Ew&maxResults=2&fields=pageInfo%2Citems(id%2Csnippet(title%2Cdescription%2Cthumbnails(default)))&key={YOUR_API_KEY}';

      $cmd = 'https://www.googleapis.com/youtube/v3/playlists?part=id%2Csnippet&channelId='.$channel.'&maxResults=3&key='.$key;
      $ch = curl_init($cmd);

      $resp = curl_exec($ch);
      curl_close($ch);

      return json_decode($resp, true);
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
