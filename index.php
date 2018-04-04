<?php

  function readCSV($csvFile){
      $file_handle = fopen($csvFile, 'r');
      while (!feof($file_handle) ) {
          $line_of_text[] = fgetcsv($file_handle, 1024);
      }
      fclose($file_handle);
      return $line_of_text;
  }
  
  echo '<!DOCTYPE html>';
  echo '<html>';
  echo '<head>';
  echo '<meta http-equiv="refresh" content="10">';
  echo '<title>Needed Spots</title>';
  echo '</head>';
  echo '<body>';
  echo '<h2>NEEDED SPOTS FROM HAM-ALERT</h2>';
  echo '<pre>';
  //$content = file_get_contents('spots.txt');
  $rows = readCSV('spots.csv');
  //P5/SM5COP/P,21001.0,SM5AJV,RTTY,2018-04-02,14:32,RBN,AJV-trigger
  //SV8RV,J5MW,7030.2,CW,RBN,2018-04-02,15:26,
  //0     1    2      3  4   5           6
  printf("%-13s %-13s %10s  %-8s %-5s %-12s %-10s\n", 
         "DE", "DX", "FREQ", "MODE", "UTC", "DATE", "SOURCE");
  printf("----------------------------------------------------------------------------\n");
  $n = 0;
  $max_lines = 20;
  foreach (array_reverse($rows) as $row) {
    if (strlen($row[0])> 0) {
      printf("%-13s %-13s %10.1f  %-8s %-5s %-12s %-10s\n", 
            $row[0], $row[1], $row[2], $row[3], $row[6], $row[5], $row[4]);
      $n++;
      if ($n >= $max_lines) {
        break;
     }
    }
  }
  echo $content;
  echo '</pre>';
  echo '</body>';
  echo '</html>';
       
	
?>