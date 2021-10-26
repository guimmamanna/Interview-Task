<?php
include('class.php');

//read csv file
$file = file("harvest_data_clean.csv");

//Read Override csv file
$override_file = file("override.csv");

//open error log file
$error_log_file = fopen("error_log_file.txt", "w");

//crop codes transformed to name
$var = new county('W', 'Wheat');
$var2 = new county('B', 'Barley');
$var3 = new county('M', 'Maize');
$var4 = new county('BE', 'Beetroot');
$var5 = new county('C', 'Carrot');
$var6 = new county('PO', 'Potatoes');
$var7 = new county('PA', 'Parsnips');
$var8 = new county('O', 'Oats');

//array of crop codes and names
$array_of_county_code = array($var, $var2, $var3, $var4, $var5, $var6, $var7, $var8);

foreach ($file as $k)
    //Obtain an array call csv2 from the csv file
    $csv2[] = explode(', ', $k);
    //sum up the crops of a county and give its percentage
   $sum_per_county = array();
    $row_length = count($csv2);
    for($row=0; $row<$row_length; $row++){
       $sum_per_county[$row] = 0;
        for($value=0; $value<count($csv2[$row]); $value++){
            if($value == 0){
                $value += 2;
            }
           $sum_per_county[$row] += intval($csv2[$row][$value]);
            $value += 1;
        }
    }
    //End the sums

    printf("<table>");
    print("<tr> <th>| County |</th> <th>| Crop Name |</th> <th>| Harvest Percent|</th>");
    for($row =0; $row<$row_length; $row++){
        for($in_row=1; $in_row<count($csv2[$row]); $in_row++){
            //Check error
            if(intval($csv2[$row][$in_row])){
                fwrite($error_log_file, "problem, Error on line  : ".($row+1)." , ". $csv2[$row][$in_row]. " not crop code. \n");
                $in_row = $in_row+1;
                continue;
            }elseif ($csv2[$row][$in_row] == ""){
                $in_row = $in_row+1;
                continue;
            }elseif($csv2[$row][$in_row] == ","){
                $in_row = $in_row+1;
                continue;
            }

            //verify county crop code names
            foreach($array_of_county_code as $sub_region){
                if(strtoupper($csv2[$row][$in_row]) == $sub_region->crop_code){
                    $csv2[$row][$in_row] = $sub_region->crop_name;
                }
            }
            print("<tr> <th>".$csv2[$row][0]."</th>");
            printf("<th>".$csv2[$row][$in_row]." </th> <th> %.4s %% </th></tr>", (intval($csv2[$row][$in_row+1])*100)/$sum_per_county[$row]);
            $in_row = $in_row+1;
        }
    }
    printf("</table>");

?>