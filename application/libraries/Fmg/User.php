<?php

namespace Fmg;

if (!defined('BASEPATH')) exit('All your direct script access are belong to us');

/**
 * Class Fmg\User
 *
 * @author Rodrigo Silveira
 * Copyright (c) 2014 Formigone.
 */
class User {

   /**
    * @var int $id
    */
   protected $id;

   /**
    * @var string $username
    */
   protected $username;

   /**
    * @param int $id
    * @param string $username
    */
   public function __construct($id, $username){
      $this->id = $id;
      $this->username = $username;
   }

   /**
    * @return int
    */
   public function getId() {
      return $this->id;
   }

   /**
    * @return string
    */
   public function getUsername() {
      return $this->username;
   }
}
