<?php
			include("category_option_combo_lookup.php");
			include("lookup_gender.php");
			include("lookup_dhis_id.php");
			include("dhis2datavaluewrapper.php");
			$age=$_REQUEST["age"];
			$gender=$_REQUEST["gender"];
			$vacc_code=$_REQUEST["vacc_code"];
			$facility=$_REQUEST["facility"];
			$date_range=$_REQUEST["date"];
			$sequence=$_REQUEST["sequence"];
		  fetch_immunization($date_range,$gender,$facility,$vacc_code,$sequence,$age);
        function fetch_immunization($date_range="",$gender,$facility,$vacc_code,$sequence,$age) {
        		$facility_imm=$facility=str_replace("urn:uuid:","",$facility);
        		$gender_imm=lookup_gender($gender);
        		$age_gender=array($age,$gender);
        		$age_gender_combo=lookup_combo($age_gender)[0];
        		$date=explode(" ",$date_range);
        		$date_lower=current($date);
        		$date_higher=end($date);
        		//look up the data element(BCG) uid for DHIS2
        		$de_uid=lookup_uuid($vacc_code);
        		$ch = initialize_curl();
        		$url="http://41.86.176.87:8080/fhir/Immunization?facility.identifier=$facility_imm&patient.gender=$gender_imm&vaccine-code=$vacc_code&_count=0&_format=json";
        		curl_setopt($ch, CURLOPT_URL, $url);
        		$data = curl_exec($ch);
        		$data=json_decode($data,true);
        		echo "<center><b>".$data["total"]."</b> BCG Vaccines Found</center>";
        		echo "FHIR Immunization BCG Code=".$vacc_code."<br> FHIR Immunization Gender = ".$gender_imm."<br> FHIR Immunization Age = ".$age."<br>DHIS BCG UID=".$de_uid."<br> Data Submitted To DHIS2 For Q2 = ";
        		$dhis2SaveWrapper = new DHIS2SaveWrapper("http://10.42.0.48:8080/dhis","tzcattest","TZCATTEST2016");
        		$facility_dhis="C7CbWUh3ZGZ";
        		$dhis2SaveWrapper->addDataValue($facility_dhis,$de_uid,$age_gender_combo,"2016Q2",$data["total"]);
				$json=json_decode($dhis2SaveWrapper->getDataValueJSONPayload());
				echo "<pre>".json_encode($json,JSON_PRETTY_PRINT)."</pre>";
				$sent_json=json_decode($dhis2SaveWrapper->save());
				echo "DHIS Submitted Results <pre>".json_encode($sent_json,JSON_PRETTY_PRINT)."</pre>";
        }
?>