<?php
include('class.php');
//read csv file
$file = file('harvest data - clean.csv');
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
for($row=0; $row<$row_length; $row++) {
    if($value ==0){$value +=2;
    }
    $sum_of_county[$row] +=intval($csv2[$row][$value]);
    $value +=1;
}
//End the sums
 print("table");
 print("<tr> <th> | County | </th> <th> | Crop Name | </th> |<th> | %Harvested | </th>");
 for($row = 0; $row<$row_length; $row++){
//Check error
if (intval($csv2[$row])){
    fwrite($error_log_file, "There is an Error on line : ".($row+1).".". $csv2[$row][$in_row]. "There is an error with your Crop code. \n");
    $in_row = $in_row +1;
    continue;
}
elseif($csv2[$row][$in_row] == "") 
 {
    $in_row = $in_row +1;
    continue;
}
elseif($csv2[$row][$in_row] == ",") 
$in_row = $in_row +1;
    continue;
}
//verify county crop code names
foreach($array_of_county as $county){
    if(strtoupper($csv2[$row][$in_row]) == $county->crop_code)
    {
        $csv2[$row][$in_row] = $county->crop_name;
    }
}
printf("<tr> <th>" .$csv2[$row][0][$in_row].)
 
 
?>