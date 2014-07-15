<?php

define('DB_HOST', 'localhost');
define('DB_DATABASE', 'elt_2_0');
define('DB_USER', 'root');
define('DB_PWD', '');

function getDb() {
   $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PWD);

   return $db;
}

function findById(PDO $db, $tablename, $id) {
   $tablename = filter_var($tablename, FILTER_SANITIZE_STRING);
   $stm = $db->prepare('select * from ' . $tablename . ' where id = :id');
   $stm->setFetchMode(PDO::FETCH_ASSOC);

   if ($stm->execute(['id' => $id])) {
      $res = $stm->fetchAll();
   }

   return @$res[0] ? : [];
}

function update(PDO $db, $tablename, array $data) {
   $in = findById($db, $tablename, $data['id']);

   if (md5(json_encode($in)) !== md5(json_encode($data))) {
      $tablename = filter_var($tablename, FILTER_SANITIZE_STRING);

      $sql = 'update ' . $tablename . ' set ';
      foreach ($data as $key => $val) {
         if ($key !== 'id') {
            $sql .= $key . '=:' . $key . ',';
         }
      }
      $sql .= 'id=:id where id = :id';

      echo $sql, "\n";
      echo "[{$tablename} => ", json_encode($data), "\n\n";

      $stm = $db->prepare($sql);
      $stm->setFetchMode(PDO::FETCH_ASSOC);

      return $stm->execute($data);
   }

   return false;
}

function insert(PDO $db, $tablename, array $data) {
   $tablename = filter_var($tablename, FILTER_SANITIZE_STRING);

   unset($data['id']);
   $keys = array_keys($data);

   $sql = 'insert into ' . $tablename . ' (' . implode(',', $keys) . ') values (';
   foreach ($data as $key => $val) {
      $sql .= ':' . $key . ',';
   }

   $sql = substr($sql, 0, -1);
   $sql .= ')';

   echo $sql, "\n";
   echo "[{$tablename} => ", json_encode($data), "\n\n";

   $stm = $db->prepare($sql);

   return $stm->execute($data);
}


if ($argc < 2) {
   exit("Usage: {$argv[0]} <input_json>\n");
}

$filename = $argv[1];

printf("Syncing <%s>...\n", $filename);
$xml = file_get_contents($filename);
$xml = simplexml_load_file($filename);

$db = getDb();
$db->beginTransaction();

// Data coming from BlueHost
//foreach ($xml->database->table_data as $table) {
//   $_t = json_decode(json_encode($table), true);
//   $tablename = $_t['@attributes']['name'];
//   $d = [];
//
//   foreach ($table as $k => $v) {
//      $key = $v['name'] . '';
//      $val = $v . '';
//      $d[$key] = preg_replace('|\s\s+|', '', $val);
//   }
//
//   if (array_key_exists('id', $d)) {
//      if (findById($db, $tablename, $d['id'])) {
//         update($db, $tablename, $d);
//      } else {
//         insert($db, $tablename, $d);
//      }
//   }
//}


// Data coming from localhost
foreach ($xml->database->table_data as $table) {
   $_t = json_decode(json_encode($table), true);
   $tablename = $_t['@attributes']['name'];

   foreach ($table->row as $row) {
      $d = [];
      foreach ($row->field as $k => $v) {
         $key = $v['name'] . '';
         $val = $v . '';
         $d[$key] = $val;
      }

      if (array_key_exists('id', $d)) {
         if (findById($db, $tablename, $d['id'])) {
            update($db, $tablename, $d);
         } else {
            insert($db, $tablename, $d);
         }
      }
   }
}
$db->commit();