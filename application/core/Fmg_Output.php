<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author vee
 * @copyright http://www.okvee.net
 */

class Fmg_Output extends CI_Output {
   function __construct() {
      parent::__construct();
   }

   /**
    * Update/serve a cached file
    *
    * @access    public
    * @return    void
    */
   function _display_cache(&$CFG, &$URI) {
      $cache_path = ($CFG->item('cache_path') == '') ? APPPATH . 'cache/' : $CFG->item('cache_path');

      $uri = $CFG->item('base_url') .
         $CFG->item('index_page') .
         $URI->uri_string;

      $querystrings = $_SERVER['QUERY_STRING'];
      if ($querystrings != null) {
         $querystrings = "?" . $querystrings;
      }

      $uri = $uri . $querystrings;
      $filepath = $cache_path . md5($uri);

      if (!@file_exists($filepath)) {
         return FALSE;
      }

      if (!$fp = @fopen($filepath, FOPEN_READ)) {
         return FALSE;
      }

      flock($fp, LOCK_SH);

      $cache = '';

      if (filesize($filepath) > 0) {
         $cache = fread($fp, filesize($filepath));
      }

      flock($fp, LOCK_UN);
      fclose($fp);

      if (!preg_match("/(\d+TS--->)/", $cache, $match)) {
         return FALSE;
      }

      if (time() >= trim(str_replace('TS--->', '', $match['1']))) {
         if (is_really_writable($cache_path)) {
            @unlink($filepath);

            return FALSE;
         }
      }

      $this->_display(str_replace($match['0'], '', $cache));

      return TRUE;
   }

   /**
    * Write a Cache File
    *
    * @access    public
    * @return    void
    */
   function _write_cache($output) {
      $CI =& get_instance();
      $path = $CI->config->item('cache_path');
      $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

      if (!is_dir($cache_path) OR !is_really_writable($cache_path)) {
         return;
      }

      $uri = $CI->config->item('base_url') .
         $CI->config->item('index_page') .
         $CI->uri->uri_string();

      $querystrings = $_SERVER['QUERY_STRING'];

      if ($querystrings != null) {
         $querystrings = "?" . $querystrings;
      }

      $uri = $uri . $querystrings;
      $cache_path .= md5($uri);

      if (!$fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
         return;
      }

      $expire = time() + ($this->cache_expiration * 60);

      if (flock($fp, LOCK_EX)) {
         fwrite($fp, $expire . 'TS--->' . $output);
         flock($fp, LOCK_UN);
      } else {
         return;
      }

      fclose($fp);
      @chmod($cache_path, FILE_WRITE_MODE);
   }
}

/* End of file compress.php */
/* Location: ./system/application/hooks/compress.php */

