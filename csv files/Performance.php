<?php
include('class.php');

//Global variables
$array_of_county_code = array();


//Define my function
//Adding crop code and name

function crop_code_name($crop_code, $crop_name){
    global $array_of_county_code;
     array_push ($array_of_county_code, new CropCodeName($crop_code, $crop_name));
}

//function to obtain override csv array
function csv_array($csv_file){
    foreach($csv_file as $k)
$csv[] = explode(", ", $k);
return $csv;
}

//Function to check whether county and crop codes exist in override file
function check_county_code($harvest_array, $override_array){
    for($row=0; $row<count($harvest_array);$row++){
        for ($o_row=0; $o_row<count($override_array); $o_row++){
            if($harvest_array[$row][0] == $override_array[$o_row][0]){
                for($io_row=1; $io_row<count($override_array[$o_row]); $io_row++){
                  //var added check only once if override crop exist in harvest data crop code
                  $added = false;
                  for($ih_row=1; $ih_row<count($harvest_array[$row]); $ih_row ++){

                  }

                }
            }
        }
    }
}

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
                fwrite($error_log_file, "There is an Error on line  : ".($row+1)." , ". $csv2[$row][$in_row]. " its not a crop code. \n");
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