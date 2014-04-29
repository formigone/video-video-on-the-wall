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
   const ACTION_PLAYLIST_ITEMS = 'playlistItems';

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
      $extra = 'channelId='. $channel;

      $cmd = $this->buildUrl(self::ACTION_PLAYLIST, $parts, $fields, $extra, $max);

      $ch = curl_init($cmd);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $resp = curl_exec($ch);
      curl_close($ch);

      return json_decode($resp, true);
   }

   /**
    * @param string $playlist
    * @param int (optional) $max
    *
    * @return array
    */
   public function fetchPlaylistVideos($playlist, $max = 3){
//      return json_decode('{ "pageInfo": { "totalResults": 21, "resultsPerPage": 2 }, "items": [ { "id": "PLGJDCzBP5j3y3uxsElO_HYvPpkjnu-UNW", "snippet": { "title": "Dependency Injection", "description": "", "thumbnails": { "default": { "url": "https://i.ytimg.com/vi/egONoRg_Gjg/default.jpg" } } } }, { "id": "PLGJDCzBP5j3wU-jFiUPrRs_pHhIO7WRkU", "snippet": { "title": "AngularJS Game Development Tutorials", "description": "Learn how to create 2D games using Angular.js and HTML5. The Tile-based map editor created in this tutorials is open-source, and is a built-in (but standalone) component of the RokkoJS game engine. Check out the JavaScript game framework Git repository at https://github.com/formigone/rokkojs", "thumbnails": { "default": { "url": "https://i.ytimg.com/vi/jt5a9aXn4lg/default.jpg" } } } } ] }', true);

      $parts = 'id,snippet';
      $fields = 'pageInfo,items(id,snippet(title,position,description,thumbnails(default)))';
      $extra = 'playlistId='.$playlist;

      $cmd = $this->buildUrl(self::ACTION_PLAYLIST_ITEMS, $parts, $fields, $extra, $max);
//exit($cmd);
//
//$a = 'https://www.googleapis.com/youtube/v3/playlistItems?part=id%2Csnippet&fields=pageInfo%2Citems%28id%2Cposition%2Csnippet%28title%2Cdescription%2Cthumbnails%28default%29%29%29&playlistId=PLGJDCzBP5j3wAb2JwheEyf8uep7CXUaD-&maxResults=3&key=AIzaSyDXJFqEr9m30a9qyPCBukC-LzmyxjSPbf0';
//$b = 'https://www.googleapis.com/youtube/v3/playlistItems?part=id%2Csnippet&fields=pageInfo%2Citems(id%2Csnippet(title%2Cposition%2Cdescription%2Cthumbnails(default)))            &playlistId=PLGJDCzBP5j3wAb2JwheEyf8uep7CXUaD-&maxResults=3&key=';

      $ch = curl_init($cmd);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $resp = curl_exec($ch);
      curl_close($ch);

      return json_decode($resp, true);
   }

   /**
    * @param string $action
    * @param string $parts
    * @param string $fields
    * @param string (optional) $extra
    * @param int (optional) $max
    *
    * @return string
    */
   protected function buildUrl($action, $parts, $fields, $extra = '', $max = 3) {
      $parts = urlencode($parts);
      $fields = urlencode($fields);

      return sprintf('%s%s?part=%s&fields=%s&%s&maxResults=%d&key=%s',
         self::URL, $action, $parts, $fields, $extra, $max, $this->key
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
