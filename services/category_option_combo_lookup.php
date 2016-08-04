<?php
/**
 * Created by PhpStorm.
 * User: issy
 * Date: 8/4/16
 * Time: 3:40 PM
 */
require_once("initialize_curl.php");
#this is the received array of the requested combo, can accept multiple elements
$requested_codes_to_search_array    = array("mtUMlCLFTTz");
#$requested_codes_to_search_array    = array("NUUhXEngiby", "syxWmui9UMq");

$results_found                      = array(); #adding the results obtained so if there is more than one result that matches we pick only the first

#echo the result of the lookup
//echo "the result of the lookup is ".$results_found[0];

function lookup_combo($single_cat) {
    $code_array     =$single_cat; #this is now the array of the requested codes to match
    $result         =array();
    $result_index   = 0;

    #initializer
    $ch = initialize_curl();
    $url="http://fhirtest.uhn.ca/baseDstu3/ConceptMap/DHIS-BCG-CATEGORY-OPTIONCOMBOS-to-AGE-GENDER-CATEGORIES?_format=json";
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    $data=json_decode($data,true);
    $json=$data['group'][0]['element'];

    #first loop through the array to find the match elements
    #if an element is found to match it will be added to the $result_found
    foreach($json as $key => $value)
    {
        $code_to_add_to_array = $value['code'];
        $cat_options_local = $value['target'];
        $match_matrix = array(); #define the matrix
        #loop through a target array to create a match matrix
        for ($i=0; $i<sizeof($code_array); $i++){
            $match_matrix[$i] = false;
        }

        #check to see if the codes provided to check and the size of the
        #target we are looking are the same if not skip
        if (sizeof($cat_options_local) == sizeof($code_array)){
            #loop through the requested codes to search
            for ($j=0; $j<sizeof($code_array); $j++){
                #loop through the local target to see if there is any that matches the current search value
                foreach ($cat_options_local as $key1 => $local_target_item){
                    #echo "local is ".$local_target_item['code']." searched is ".$code_array[$j];
                    #match and report
                    if ($local_target_item['code'] == $code_array[$j]){
                        $match_matrix[$j] = true;
                    }
                }
            }

        }

        #inpect the match matrix if there is a full match then add the result to the results array
        $matrix_flag = 0;
        if (in_array(false, $match_matrix)) {
        }else{
            $result[$result_index] = $code_to_add_to_array;
            $result_index++;
        }
    }

    #return the result to the caller
    return $result;
}