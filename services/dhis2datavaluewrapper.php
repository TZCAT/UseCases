<?php

	/**
	 * Wrapper class for dhis2 data values
	 * 
	 * Author: Vincent P. Minde
	 * 
	 * */
	class DHIS2SaveWrapper
	{
		private $url;
		private $username;
		private $password;
		private $dataValues = array();
		
		/**
		 * @param url of the dhis server
		 * @param username for the server
		 * @param password of the server
		 * 
		 * */
		public function __construct($url,$username,$password) {
			$this->url = $url;
			$this->username = $username;
			$this->password = $password;
		}
		
		/**
		 * Gets the datavalue representation in dhis
		 * 
		 * @param org_uuid organisation unit uuid
		 * @param de_uuid data element uuid
		 * @param category_option_id category option combo uuid
		 * @param period the period to be used
		 * @param value the value to be used
		 * 
		 * return array the dataValue
		 * 
		 * */
		function getDataValue($org_uuid,$de_uuid,$category_option_id,$period,$value){
			return (array(dataElement => $de_uuid,categoryOptionCombo => $category_option_id, period => $period,orgUnit => $org_uuid,value => $value));
		}
		/**
		 * Gets the datavalue representation in dhis
		 * 
		 * @param org_uuid organisation unit uuid
		 * @param de_uuid data element uuid
		 * @param category_option_id category option combo uuid
		 * @param period the period to be used
		 * @param value the value to be used
		 * 
		 * return json object of the dataValue
		 * 
		 * */
		function getDataValueJSON($org_uuid,$de_uuid,$category_option_id,$period,$value){
			return json_encode($this->getDataValue($org_uuid,$de_uuid,$category_option_id,$period,$value));
		}
		/**
		 * Add datavalue for saving as an array to dhis representation in dhis
		 * 
		 * @param org_uuid organisation unit uuid
		 * @param de_uuid data element uuid
		 * @param category_option_id category option combo uuid
		 * @param period the period to be used
		 * @param value the value to be used
		 * 
		 * return json object of the dataValue
		 * 
		 * */
		function addDataValue($org_uuid,$de_uuid,$category_option_id,$period,$value){
			array_push($this->dataValues , $this->getDataValue($org_uuid,$de_uuid,$category_option_id,$period,$value));
		}
		
		/**
		 * Gets the datavalues payload ready for saving representation in dhis
		 * 
		 * return object the dataValue representation for saving
		 * 
		 * */
		function getDataValuePayload(){
			return array(dataValues => $this->dataValues);
		}
		/**
		 * Gets the datavalues payload ready for saving representation in dhis
		 * 
		 * return object the dataValue representation for saving
		 * 
		 * */
		function getDataValueJSONPayload(){
			return json_encode($this->getDataValuePayload());
		}
		/**
		 * Save data to dhis2
		 * 
		 * return json from dhis results or error code
		 * 
		 * */
		function save(){
			$curl = $this->initialize_curl();
			$data = curl_exec($curl);
			if ($data != false){
				$info = curl_getinfo($curl);
				if($info["http_code"] == "200"){
					return $data;
				}else{
					return $info["http_code"];
				}
			}else{
				return 0;
			}
		}
		function initialize_curl() {
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $this->url."/api/dataValueSets");
			curl_setopt($ch, CURLOPT_USERPWD, $this->username.":".$this->password);
			$data = json_encode($this->getDataValuePayload());
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json',                                                                                
				'Content-Length: ' . strlen($data))                                                                       
			); 
			return $ch;
		}
	}

/*
Exampole Usage
	$dhis2SaveWrapper = new DHIS2SaveWrapper("http://localhost:8080/dhis","","");
	$dhis2SaveWrapper->addDataValue("m0frOspS7JY","DyJsbZOZFwE","uGIJ6IdkP7Q","2016Q2","10");
	
	echo $dhis2SaveWrapper->getDataValueJSONPayload();
	
	$dhis2SaveWrapper->save();
*/
?>
