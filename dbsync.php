<?php

define('DB_HOST', 'localhost');
define('DB_DATABASE', 'elt_2_0');
define('DB_USER', 'root');
define('DB_PWD', '');

function getDb(){
   $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE, DB_USER, DB_PWD);
   return $db;
}

function findById(PDO $db, $tablename, $id) {
   $tablename = filter_var($tablename, FILTER_SANITIZE_STRING);
   $stm = $db->prepare('select * from '.$tablename.' where id = :id');
   $stm->setFetchMode(PDO::FETCH_ASSOC);

   if($stm->execute(['id' => $id])) {
      $res = $stm->fetchAll();
   }

   return @$res[0] ?: [];
}

function update(PDO $db, $tablename, array $data) {
   $in = findById($db, $tablename, $data['id']);

   if (md5(json_encode($in)) !== md5(json_encode($data))) {
      echo " ~~ {$tablename}\n";
      echo "    id {$data['id']}\n";
      echo "  NEW ", json_encode($data), "\n";
      echo "  OLD ", json_encode($in), "\n\n";
   }
}

function insert(PDO $db, $tablename, array $data) {
   echo " ++ {$tablename}\n";
}


if ($argc < 2) {
   exit("Usage: {$argv[0]} <input_json>\n");
}

$filename = $argv[1];

printf("Syncing <%s>...\n", $filename);
$xml = file_get_contents($filename);
$xml = simplexml_load_file($filename);

$db = getDb();

foreach ($xml->database->table_data as $table) {
   $_t = json_decode(json_encode($table), true);
   $tablename = $_t['@attributes']['name'];

   foreach ($table->row as $row) {
      $d = [];
      foreach ($row->field as $k => $v) {
         $key = $v['name'].'';
         $val = $v.'';
         $d[$key] = $val;
      }

      if(findById($db, $tablename, $d['id'])) {
         update($db, $tablename, $d);
      } else {
         insert($db, $tablename, $d);
      }
   }
}
