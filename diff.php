<?php

function bucketize($sql) {
   $sql = explode("\n", $sql);
   $res = [];
   $table = 'fake_table';

   foreach ($sql as $s) {
      if (preg_match('|insert into (\w+) values|i', $s, $_table)) {
         $table = $_table[1];
         $res[$table] = [];
      } else {
         if ($s != '' && array_key_exists($table, $res)) {
            $data = explode("','* * * * * * *','", $s);
            preg_match('|.(\d+)|', $data[0], $id);
            if (count($id) < 1) {
               continue;
            }

            $row = [
               'id' => $id[1]
            ];

            foreach ($data as $i => $field) {
               if ($i > 0) {
                  $row["key{$i}"] = $field;
               }
            }

            array_push($res[$table], $row);
         }
      }
   }

   echo json_encode($res);
   exit;

   return $res;
}

function getInserts($sql) {
   $res = [];
   $sql = explode('(', $sql);
   $table = '';

   foreach ($sql as $i => $row) {
      if ($i === 0) {
         preg_match('|insert into .(\w+).|i', $row, $table);
         $table = $table[1];
         $res[$table] = [];
         continue;
      }

      $str = preg_replace('|\s+|', ' ', substr($row, 0, -2));
//      $str = str_replace("\\'", "", $str);
      $str = str_replace("''", "", $str);
      array_push($res[$table], $str);
   }

   return $res;
}

function process($file) {
   $rows = explode("\n", $file);
   $data = [];

   foreach ($rows as $row) {
      if (preg_match('|insert into|i', $row) && !preg_match('|ci_sessions|i', $row)) {
         $data = $data + getInserts($row);
      }
   }

   return $data;
}

$a = file_get_contents('comp_loc.json');
$b = file_get_contents('comp_rem.json');
//$a = file_get_contents('comp_loc3.sql');
//$b = file_get_contents('comp_rem.sql');

//echo str_replace("),(", "),\n(", $a);exit;
//echo str_replace(",\n", ",", $a);exit;
//echo $a;exit;
//$a = process($a);
//$b = process($b);

bucketize($b);

foreach ($a as $key => $data) {
   echo "\n=======\n$key\n=======\n";
//   echo json_encode($data);

   foreach ($data as $i => $val) {
      if (!empty($b[$key][$i])) {
         if ($val !== $b[$key][$i]) {
            echo "[{$val}]\n- - - - - - -\n[{$b[$key][$i]}]\n\n";
         }
      }
   }
}