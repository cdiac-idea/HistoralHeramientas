<?php
$newCsvData = array();
if (($handle = fopen("test.csv", "r")) !== FALSE) {

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $data[] = 'hora';
        $newCsvData[] = $data;
    }
    fclose($handle);
}

$handle = fopen('test.csv', 'w');

foreach ($newCsvData as $line) {
   fputcsv($handle, $line);
}

fclose($handle);
 echo "fin";
?>