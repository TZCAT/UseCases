<?php
			$age=$_REQUEST["age"];
			$gender=$_REQUEST["gender"];
			$vacc_code=$_REQUEST["vacc_code"];
			$facility=$_REQUEST["facility"];
			$date_range=$_REQUEST["date"];
			$sequence=$_REQUEST["sequence"];
		  fetch_immunization($date_range,$gender,$facility,$vacc_code,$sequence);
        function fetch_immunization($date_range="",$gender="NL",$facility="NL",$vacc_code="NL",$sequence="NL") {
        		$date=explode(" ",$date_range);
        		$date_lower=current($date);
        		$date_higher=end($date);
        		$ch = initialize_curl();
        		$url="http://fhirtest.uhn.ca/baseDstu2/Immunization?date=ge$date_lower&date=le$date_higher&vaccine-code=$vacc_code&_format=json";
        		curl_setopt($ch, CURLOPT_URL, $url);
        		$data = curl_exec($ch);
        		$data=json_decode($data,true);
        		echo "<center><b>".$data["total"]."</b> Immunizations Found</center>";
        }
        
        function initialize_curl() {
        		$ch = curl_init();
        		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        		curl_setopt($ch, CURLOPT_VERBOSE, true);
        		return $ch;
        }
?>