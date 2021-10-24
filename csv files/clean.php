<?php

// open harvest data csv file
$path = fopen('harvest data - clean.csv', 'r');

// read file
while (($data = fgetcsv($path, 1000, ',')) !==FALSE)
{
    echo"<pre>"; print_r($data);
}
fclose($path);
?>