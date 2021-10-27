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
                      //check if crop code from override exists in harvest data file
                      if($override_array[$o_row][$io_row] == $harvest_array[$row] [$ih_row]){
                          //override existing crop quantity
                          $harvest_array[$row] [$ih_row+1] =$override_array[$o_row][$io_row+1];
                      }
                      //if crop code does not exist in harvest file add them
                      if(!in_array($override_array[$o_row][$io_row], $harvest_array[$row]) && !$added){
                          //add override crop in harvest crop data
                          $added = true;
                      }
                      $ih_row += 1;
                      }
                      $io_row += 1;

                }
            }
        }
    }
    return $harvest_array;
}

//Read harvest data file
$file = file("harvest_data_clean.csv");

//Read Override csv file
$override_file = file("override.csv");

//Open and Write error log file
$error_log_file = fopen("error_log_file.txt", "w");

//Open and Write override file
$error_log_file = fopen("error_log_file.txt", "w");

//add crop codes and names
crop_code_name('W', 'Wheat');
crop_code_name('B', 'Barley');
crop_code_name('M', 'Maize');
crop_code_name('BE', 'Beetroot');
crop_code_name('C', 'Carrot');
crop_code_name('PO', 'Potatoes');
crop_code_name('PA', 'Parsnips');
crop_code_name('O', 'Oats');


//Get override array from override csv file
$override_array = csv_array($override_csv_file);

//Get harvest array from harvest csv file
$harvest_array = csv_array($file);

//check if there is a duplicate in override file
$csv2 = check_county_code($harvest_array, $override_array);

//sum all the percentage of crops depending on county's
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
 
    //Print output after analysis
    printf("<table>");
    print("<tr> <th>| County |</th> <th>| Crop Name |</th> <th>| Harvest Percent|</th>");
    for($row =0; $row<$row_length; $row++){
        for($in_row=1; $in_row<count($csv2[$row]); $in_row++){
            //Check error if data is a crop code
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

            //Display county crop code names
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