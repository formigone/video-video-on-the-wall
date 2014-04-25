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
    * @param int (optional) $max
    *
    * @return array
    */
   public function fetchPlaylists($channel, $max = 3){
//      return json_decode('{ "pageInfo": { "totalResults": 21, "resultsPerPage": 2 }, "items": [ { "id": "PLGJDCzBP5j3y3uxsElO_HYvPpkjnu-UNW", "snippet": { "title": "Dependency Injection", "description": "", "thumbnails": { "default": { "url": "https://i.ytimg.com/vi/egONoRg_Gjg/default.jpg" } } } }, { "id": "PLGJDCzBP5j3wU-jFiUPrRs_pHhIO7WRkU", "snippet": { "title": "AngularJS Game Development Tutorials", "description": "Learn how to create 2D games using Angular.js and HTML5. The Tile-based map editor created in this tutorials is open-source, and is a built-in (but standalone) component of the RokkoJS game engine. Check out the JavaScript game framework Git repository at https://github.com/formigone/rokkojs", "thumbnails": { "default": { "url": "https://i.ytimg.com/vi/jt5a9aXn4lg/default.jpg" } } } } ] }', true);

      $parts = 'id,snippet';
      $fields = 'pageInfo,items(id,snippet(title,description,thumbnails(default)))';

      $cmd = $this->buildUrl($channel, self::ACTION_PLAYLIST, $parts, $fields, $max);

      $ch = curl_init($cmd);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $resp = curl_exec($ch);
      curl_close($ch);

      return json_decode($resp, true);
   }

   /**
    * @param string $channel
    * @param string $action
    * @param string $parts
    * @param string $fields
    * @param int $max
    *
    * @return string
    */
   protected function buildUrl($channel, $action, $parts, $fields, $max) {
      $parts = urlencode($parts);
      $fields = urlencode($fields);

      return sprintf('%s%s?channelId=%s&part=%s&fields=%s&maxResults=%d&key=%s',
         self::URL, $action, $channel, $parts, $fields, $max, $this->key
      );
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
