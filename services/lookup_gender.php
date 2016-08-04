<?php
/**
 * Created by PhpStorm.
 * User: issy and carl
 * Date: 8/3/16
 * Time: 3:57 PM
 */

  /*
example usage
lookup_gender("mtUMlCLFTTz");
  */
	require_once("initialize_curl.php");
    function lookup_gender($gender_code) {
        $code=$gender_code;
        $ch = initialize_curl();
        $url="http://fhirtest.uhn.ca/baseDstu3/ConceptMap/bcg-gender-to-fhir-gender-tz/?_format=json";
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        $data=json_decode($data,true);
        $json=$data['group'][0]['element'];
        foreach($json as $key => $value)
        {
            $found = $value['code'];
            if ($found == $code){
                $target = $value['target'];
                foreach($target as $key => $local_code){
                    return $local_code['code'];
                }
            }
        }
    }
?>