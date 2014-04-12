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

   public function __construct($params){
      $this->db = $params[0];
   }

   public function getMockSeries() {
      return $this->db->getMockSeries();
   }
}
