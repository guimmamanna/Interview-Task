<?php
//read csv file
$file = file('harvest data-clean.csv');
$error_log_file = fopen(".error_log_file.txt", "w");
//crop codes transform to name
$var = new county('w', 'Wheat');
$var2 = new county('B', 'Barley');
$var3 = new county('M', 'Maize');
$var4 = new county('BE', 'Beetroot');
$var5 = new county('C', 'Carrot');
$var6 = new county('PO', 'Potatoes');
$var7 = new county('PA', 'Parsnips');
$var8 = new county('O', 'Oats');
// array of crop codes name
$array_of_county= array($var, $var2,$var3,$var4,$var5,$var6,$var7,$var8,);
foreach ($file as $K)
//obtain an array called csv2 from the csv file
$csv2[] = explode(',', $k);
//sum up the crops of a county and give its percentage
$sum_of_county = array();
$row_length = count($csv2);
for($row=0; $row<$row_length; $row++)

?>