<?php

  
  function readCSV($csvFile){
      $file_handle = fopen($csvFile, 'r');
      while (!feof($file_handle) ) {
          $line_of_text[] = fgetcsv($file_handle, 1024);
      }
      fclose($file_handle);
      return $line_of_text;
  }
  
  function printRawTable($rows) {
    //P5/SM5COP/P,21001.0,SM5AJV,RTTY,2018-04-02,14:32,RBN,AJV-trigger
    //SV8RV,J5MW,7030.2,CW,RBN,2018-04-02,15:26,
    //0     1    2      3  4   5           6
    $n = 0;
    $max_lines = 20;
    echo '<pre>';
    printf("%-13s %-13s %10s  %-8s %-5s %-12s %-12s %-16s %-16s\n", 
           "DE", "DX", "FREQ", "MODE", "UTC", "DATE", "SOURCE", "TRIGGER", "ENTITY");
    printf("-----------------------------------------------------------------------------------------\n");
    foreach (array_reverse($rows) as $row) {
      if (strlen($row[0])> 0) {
        printf("%-13s %-13s %10.1f  %-8s %-5s %-12s %-12s %-16s\n", 
              $row[0], $row[1], $row[2], $row[3], $row[6], $row[5], $row[4], $row[8], $row[7]);
        $n++;
        if ($n >= $max_lines) {
          break;
       }
      }
    }
    echo '</pre>';          
  }
  
  function printHtmlTable($rows, $max_lines) {
    $n = 0;
    printf('<table>');
    printf('<tr><th>DE</th> <th>DX</th> <th>FREQ</th> <th>MODE</th> 
                <th>UTC</th> <th>DATE</th> <th>SOURCE</th> <th>TRIGGER</th> <th>ENTITY</th> </tr>');
    foreach (array_reverse($rows) as $row) {
      if (strlen($row[0])> 0) {
        printf("<tr><td>%-13s</td> 
                    <td><a href=https://www.qrz.com/db/%s>%-13s</a></td>
                    <td>%10.1f</td>
                    <td>%-8s</td>
                    <td>%-5s</td>
                    <td>%-12s</td>
                    <td>%-12s</td>
                    <td>%-16s</td>              
                    <td>%-16s</td></tr>\n", 
              $row[0], $row[1], $row[1], $row[2], $row[3], $row[6], $row[5], $row[4], $row[8], $row[7]);
        
        $n++;
        if ($n >= $max_lines) {
          break;
       }
      }
    }
  printf('</table>');    
  }
  
  echo '<!DOCTYPE html>';
  echo '<html>';
  echo '<head>';
  echo '<meta http-equiv="refresh" content="10">';
  echo '<title>Needed Spots</title>';
  echo '<style>
table, th, td {
    border: 0px solid black;
    border-collapse: collapse;
    font-family: Arial, Verdana, sans-serif;
    font-size: 12px;
}
th, td {
    padding: 5px;
}
th {
    text-align: left;
    background-color: #d2d5db;
}
</style>';
  echo '</head>';
  echo '</body>';

  $ini_file = "alert.ini";
  if (file_exists($ini_file)) {
    $ini = parse_ini_file($ini_file);
  }
  else {
    $ini["page_header"]= "SPOTS";
    $ini["max_lines"] = 20;
  }

  echo '<h2>' . $ini["page_header"] . '</h2>';
  $rows = readCSV('spots.csv');
  //printRawTable($rows);
  printHtmlTable($rows, $ini["max_lines"]);
  echo '</body>';
  echo '</html>';
?>
