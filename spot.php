<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php 
   $row = array($_POST['spotter'],
                $_POST['fullCallsign'],
                number_format($_POST['frequency']*1000.0, 1, '.', ''), 
                strtoupper($_POST['mode']), 
                strtoupper($_POST['source']),
                gmdate('Y-m-d'), 
                $_POST['time'],
                $_POST['triggerComment']);
   $fp = fopen('spots.csv', 'a+');
   fputcsv($fp, $row);
   fclose($fp);
 ?> 
 </body>
</html>



