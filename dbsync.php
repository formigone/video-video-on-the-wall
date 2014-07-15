<?php

if ($argc < 2) {
   exit("Usage: {$argv[0]} <input_json>\n");
}

$filename = $argv[1];

printf("Syncing <%s>...\n", $filename);
$xml = file_get_contents($filename);

$xml = simplexml_load_file($filename);

foreach ($xml->database->table_data as $table) {
   $_t = json_decode(json_encode($table), true);
   $tablename = $_t['@attributes']['name'];
   $data = [
      'name' => $tablename,
      'rows' => []
   ];

   foreach ($table->row as $row) {
      $d = [];
      foreach ($row->field as $k => $v) {
         $key = $v['name'].'';
         $val = $v.'';
         $d[$key] = $val;
      }
      array_push($data['rows'], $d);
   }

   var_dump($data);
}
