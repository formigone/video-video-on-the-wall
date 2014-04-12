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
   public function getMockSeries() {
      return $this->db->getMockSeries();
   }

   /**
    *
    */
   public function testDb(){
      return $this->db->testDb();
   }
}
