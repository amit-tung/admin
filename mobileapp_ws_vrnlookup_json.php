<?php  
header('Access-Control-Allow-Origin: *');
mb_internal_encoding('UTF-8');
header("Content-type: application/json; charset=utf-8");
	function get_data($URL , $xml_data) {
		$ch = curl_init($URL);
		curl_setopt($ch , CURLOPT_MUTE , 1);
		curl_setopt($ch , CURLOPT_SSL_VERIFYHOST , 0);
		curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , 0);
		curl_setopt($ch , CURLOPT_POST , 1);
		curl_setopt($ch , CURLOPT_HTTPHEADER , array('Content-Type: text/xml'));
		curl_setopt($ch , CURLOPT_POSTFIELDS , "$xml_data");
		curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1);
		$output = curl_exec($ch);
		curl_close($ch);
		//	POST /1stchoiceservices/SupplierPub.asmx HTTP/1.1
		//	Host: webserv.1stchoice.co.uk
		//	Content-Type: text/xml; charset=utf-8
		//	Content-Length: length
		//	SOAPAction: "1stChoice/RegnoLookup"
		//
		//<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		// xmlns:xsd="http://www.w3.org/2001/XMLSchema"
		// xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
		//  <soap:Body>
		//    <RegnoLookup xmlns="1stChoice">
		//      <Username>string</Username>
		//      <Password>string</Password>
		//      <regno>string</regno>
		//      <usercode>string</usercode>
		//    </RegnoLookup>
		//  </soap:Body>
		//</soap:Envelope>
		//
		return $output;
	}

	function cartell_get_data($url) {
		$ch = curl_init();
		//$url="https://www.cartell.ie/secure/xml/findvehicle?reference=&clientid=1024&registration=05D12345&servicename=XML_Cartell_Lyons&xmltype=soap11";
		curl_setopt($ch , CURLOPT_URL , $url);
		curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
		curl_setopt($ch , CURLOPT_USERPWD , "lyonssystems:lyonsa");
		curl_setopt($ch , CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
		curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
		curl_setopt($ch , CURLOPT_HTTPAUTH , CURLAUTH_ANY);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return $output;
	}

	function xml2array($contents , $get_attributes = 1 , $priority = 'tag',$status = false) {
        
		if(!$contents)
			return array();
		if(!function_exists('xml_parser_create')) {
			//print "'xml_parser_create()' function not found!";
			return array();
		}
		//Get the XML parser of PHP - PHP must have this module for the parser to work
		$parser = xml_parser_create('');
		xml_parser_set_option($parser , XML_OPTION_TARGET_ENCODING , "UTF-8");
		# http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
		xml_parser_set_option($parser , XML_OPTION_CASE_FOLDING , 0);
		xml_parser_set_option($parser , XML_OPTION_SKIP_WHITE , 1);
		xml_parse_into_struct($parser , trim($contents) , $xml_values);
		xml_parser_free($parser);
		if(!$xml_values)
			return;
		//Hmm...
		//Initializations
		$xml_array = array();
		$parents = array();
		$opened_tags = array();
		$arr = array();
		$current = &$xml_array;
		//Refference
		//Go through the tags.
		$repeated_tag_index = array();        
        $i= 0;
        $val = '';
         if($status == true){
             
        foreach($xml_values as $check){
            if($check['tag'] != 'soap:Envelope'){
                
            if($check['tag'] == 'Model' || $check['tag'] == 'Description'){
               if($check['tag'] == 'Modal'){
                   $index = $i;
               }
              $val .= $check['value']." ";
            }
            $new_arra[] = $check;            
            $i++;
            }
        }
        //unset($new_arra[7]); // remove item at index 0
        $foo2 = array_values($new_arra);        
        //$foo2[6]['value'] = trim($val);
        $xml_values = $foo2;
        }
		//$new_arr_check[];
		foreach($xml_values as $newcheck){
			if($newcheck['tag']=='Description'){
				$newcheck['value'] = $val;
			}
			$new_arr_check[] = $newcheck;
		}
		
		
        //echo '<pre>';print_r($new_arr_check);exit;
		//Multiple tags with same name will be turned into an array
		foreach($new_arr_check as $data) {
			unset($attributes , $value);
			//Remove existing values, or there will be trouble
			//This command will extract these variables into the foreach scope
			// tag(string), type(string), level(int), attributes(array).
			extract($data);
			//We could use the array by itself, but this cooler.
			$result = array();
			$attributes_data = array();
			if(isset($value)) {
				if($priority == 'tag')
					$result = $value;
				else
					$result['value'] = $value;
				//Put the value in a assoc array if we are in the 'Attribute' mode
			}
			//Set the attributes too.
			if(isset($attributes) and $get_attributes) {
				foreach($attributes as $attr => $val) {
					if($priority == 'tag')
						$attributes_data[$attr] = $val;
					else
						$result['attr'][$attr] = $val;
					//Set all the attributes in a array called 'attr'
				}
			}
			//See tag status and do the needed.
			if($type == "open") {//The starting of the tag '<tag>'
				$parent[$level - 1] = &$current;
				if(!is_array($current) or (!in_array($tag , array_keys($current)))) {//Insert New
					// tag
					$current[$tag] = $result;
					if($attributes_data)
						$current[$tag . '_attr'] = $attributes_data;
					$repeated_tag_index[$tag . '_' . $level] = 1;
					$current = &$current[$tag];
				} else {//There was another element with the same tag name
					if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
						$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
						$repeated_tag_index[$tag . '_' . $level]++;
					} else {//This section will make the value an array if multiple tags with the
						// same name appear together
						$current[$tag] = array($current[$tag] , $result);
						//This will combine the existing item and the new item together to make an array
						$repeated_tag_index[$tag . '_' . $level] = 2;
						if(isset($current[$tag . '_attr'])) {//The attribute of the last(0th) tag must be
							// moved as well
							$current[$tag]['0_attr'] = $current[$tag . '_attr'];
							unset($current[$tag . '_attr']);
						}
					}
					$last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
					$current = &$current[$tag][$last_item_index];
				}
			} elseif($type == "complete") {//Tags that ends in 1 line '<tag />'
				//See if the key is already taken.
				if(!isset($current[$tag])) {//New Key
					$current[$tag] = $result;
					$repeated_tag_index[$tag . '_' . $level] = 1;
					if($priority == 'tag' and $attributes_data)
						$current[$tag . '_attr'] = $attributes_data;
				} else {//If taken, put all things inside a list(array)
					if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an
						// array...
						// ...push the new element into that array.
						$current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
						if($priority == 'tag' and $get_attributes and $attributes_data) {
							$current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
						}
						$repeated_tag_index[$tag . '_' . $level]++;
					} else {//If it is not an array...
						$current[$tag] = array($current[$tag] , $result);
						//...Make it an array using using the existing value and the new value
						$repeated_tag_index[$tag . '_' . $level] = 1;
						if($priority == 'tag' and $get_attributes) {
							if(isset($current[$tag . '_attr'])) {//The attribute of the last(0th) tag must be
								// moved as well
								$current[$tag]['0_attr'] = $current[$tag . '_attr'];
								unset($current[$tag . '_attr']);
							}
							if($attributes_data) {
								$current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
							}
						}
						$repeated_tag_index[$tag . '_' . $level]++;
						//0 and 1 index is already taken
					}
				}
			} elseif($type == 'close') {//End of tag '</tag>'
				$current = &$parent[$level - 1];
			}
		}
        if($status == true){
            return ($current);
        }else{
            return ($xml_array);            
        }
	}

	function send_respond($xmlsend) {
		echo $xmlsend;
	}

	//http://matchapart.com/testarea/script/mobileapp_ws_vrnlookup.php?clientid=1024&username=alyons1880&password=eh519hs&deviceid=1508308a-389e-3edc-bebb-8db4df94f429&appversion=4.5&osversion=9.2&devicename=Note&VRN=hhz6331

	#DB Connection
	require_once("../centralized/config.php");
require_once("../centralized/db.php");
	if (!function_exists('smtp_mail')) {
	 require_once ("../centralized/mailerClass/centralize_mail_class.php");
	}
	#Get varriables in request
	$output_arr =array();
	$clientID = trim($_REQUEST['clientid']);
	$username = trim($_REQUEST['username']);
	$password = trim($_REQUEST['password']);
	$deviceId = trim($_REQUEST['deviceid']);
	$vrn = trim($_REQUEST['VRN']);
	$appversion			= trim($_REQUEST['appversion']); 
	$osversion			= trim($_REQUEST['osversion']);
	$devicename			= trim($_REQUEST['devicename']);

	if(isset($appversion) && !empty($appversion)){
		$appversion	= ", [appversion] = '".$appversion."'";
	}else{
		$appversion	= "";
	}
	if(isset($osversion) && !empty($osversion)){
		$osversion	= ", [osversion] = '".$osversion."'";
	}else{
		$osversion	= "";
	}
	if(isset($devicename) && !empty($devicename)){
		$devicename	= ", [devicename] = '".$devicename."'";
	}else{
		$devicename	= "";
	}
	
	/*$str_sql_select = "SELECT * FROM [dbo].[MobileApp_Users] WHERE [ClientID] = '" . $clientID . "' AND [UserName] = '" . $username . "' AND [UserPassword] = '" . $password . "' AND [DeviceID] = '" . $deviceId . "'";*/
	
	$str_sql_select = "SELECT * FROM [dbo].[MobileApp_Users] WHERE [ClientID] = '" . $clientID . "' AND [UserName] = '" . $username . "' AND [UserPassword] = '" . $password . "' ";
	
	$sql_query = mssql_query_upgrade($str_sql_select , dblink());
	$testtest = mssql_get_last_message_upgrade();
	$count = mssql_num_rows_upgrade($sql_query);
	if($vrn) {		
		$skipcheck = 0;
		if($clientID == '1024' && $password =='test'){
			$skipcheck = 1;		
		}		
		if($skipcheck == 1){
			$sql_query = 1;
			$count = 1;
		}
		if($sql_query) {
			if($count > 0) {
				if($skipcheck == 0){
					$row = mssql_fetch_array_upgrade($sql_query);
					$vrnlookupstatus = $row['VRNLookupStatus'];
				}else{
					$vrnlookupstatus = "ALLOWED";
				}
				if($vrnlookupstatus == "ALLOWED") {
					$threeLetters = substr($vrn , 0 , 3);
					$firstLetter = substr($threeLetters , 0 , 1);
					$secondLetter = substr($threeLetters , 1 , 1);
					$thirdLetter = substr($threeLetters , 2 , 1);
					//				echo $firstLetter ."<br>";
					//				echo $secondLetter."<br>";
					//				echo $thirdLetter."<br>";
					//				exit;
					$vrn_southireland = false; 
	
					if(is_numeric($firstLetter) && is_numeric($secondLetter)) {
						if(is_string($thirdLetter)) {
							$vrn_southireland = true;
						} else {
							$vrn_southireland = false;
						}
					} else {
						$vrn_southireland = false;
					}
					//			if(is_numeric($firstLetter))
					//					$vrn_southireland = false;
					//				else
					//					if(is_string($secondLetter) && is_numeric($secondLetter))
					//						$vrn_southireland = false;
					//					else
					//						if(is_string($thirdLetter) && is_numeric($thirdLetter))
					//							$vrn_southireland = true;
					//						else
					//							$vrn_southireland = false;
                    $vrn_southireland = true; /*Force fully made it true as discussed with Ally on chat 24-08-2017*/
					if($vrn_southireland == true) {
						if($skipcheck == 0){
						
						/*$updateQuery = "UPDATE [automatch].[dbo].[MobileApp_Users] SET [VRNUsed] = ISNULL([VRNUsed],0)+2 ".$appversion . $osversion . $devicename." WHERE [ClientID] = '" . $clientID . "' AND [UserName] = '" . $username . "' AND [UserPassword] = '" . $password . "' AND [DeviceID] = '" . $deviceId . "'";  */
						
		$updateQuery = "UPDATE [automatch].[dbo].[MobileApp_Users] SET [VRNUsed] = ISNULL([VRNUsed],0)+2 ".$appversion . $osversion . $devicename." WHERE [ClientID] = '" . $clientID . "' AND [UserName] = '" . $username . "' AND [UserPassword] = '" . $password . "' ";
						
						
						
						$updateQuerySql = mssql_query_upgrade($updateQuery , dblink());
						$testtest = mssql_get_last_message_upgrade();
						$errorr = "Error";
						$subject = "$sname $errorr";
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
						$headers .= "From: Matchapart<noreply@matchapart.com>\r\n";
						$mih = "<font color='#FF0000' size='+1'>Sorry for the inconvenience, an unexpected error occured and we have been advised on this problem.<br><br>Service will resume soon, please try again later.<br><br>Thanks for your understanding</font>";
						if(!$updateQuerySql) {
							$msg .= "Error is on page " . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . "<br><br>
											Referral URL :" . $ref . "<br><br>
											User ID :" . $_SESSION['uid'] . "<br><br>
											Query :" . $updateQuery . "<br><br>
											Error :" . $testtest;
							if(@smtp_mail("alyons1880@googlemail.com" , $subject , $msg , $headers)) {
								die($mih);
							}
						}
						}
						//echo
						// $url='https://www.cartell.ie/secure/xml/findvehicle?reference=&clientid='.$clientID.'&amp;registration='.$username.'&VRN='.$vrn.'&servicename=XML_Cartell_Lyons&xmltype=soap11';
						
						$sql_livestock = "SELECT TOP 1 StockRef,VehicleID FROM [automatch].[dbo].[LiveStock] WHERE [ClientID] = '" . $clientID . "' AND [Reg] = '" . $vrn . "' order by StockRef DESC";
						$sql_livestock_query = mssql_query_upgrade($sql_livestock , dblink());						
						$rowone = mssql_fetch_array_upgrade($sql_livestock_query);												
						
						if(true){			
							$url = 'https://www.cartell.ie/secure/xml/findvehicle?reference=&clientid=' . $clientID . '&registration=' . $vrn . '&servicename=XML_Cartell_Lyons&xmltype=soap11';
							$retrived_data = cartell_get_data($url);
							//echo '<pre>fff'; print_r($retrived_data);exit;
	$reurned_array = xml2array($retrived_data , $get_attributes = 1 , $priority = 'tag',$vrn_southireland);
							//added by sanket
							//if(strpos($retrived_data, "not found")){
		if(strpos($retrived_data, "not found") || strpos($retrived_data, "UNKNOWN")){
			/*header("location:https://matchapart.com/script/mobileapp_ws_stockref_lookup_json.php?clientid=".$clientID."&searchby=part&stockref=".$vrn);*/ /* Commented on 26-12-2019 on Ally Request*/
		}    
	//echo '<pre>';print_r($reurned_array);exit;
	$reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Model'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Description'];
	unset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Description']);
	
	$output_arr['result']['registration'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Registration'];
	$output_arr['result']['make'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Make'];
	$output_arr['result']['model'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Model'];
	$output_arr['result']['description'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Description'];
	$output_arr['result']['fuelType'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['FuelType'];
	$output_arr['result']['bodyType'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['BodyType'];
	$output_arr['result']['enginenumber'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['EngineNumber'];
	$output_arr['result']['enginecapacity'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['EngineCapacity'];
	$output_arr['result']['transmission'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Transmission'];
	$output_arr['result']['manufacturedate'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['ManufactureDate'];
	$output_arr['result']['doors'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Doors'];
	$output_arr['result']['chassisnumber'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['ChassisNumber'];
	$output_arr['result']['colour'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Colour'];
	$output_arr['result']['engine_code'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['TecDoc_Engine_Code'];
	$output_arr['result']['Weight'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Weight'];
	$output_arr['status'] ='Success';		
	}					
                         
/* START - Start New Fields */
if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['PowerBHP']) && $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['PowerBHP']!=''){
$output_arr['result']['PowerBHP'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['PowerBHP'];
}

if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['PowerKW']) && $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['PowerKW']!=''){
$output_arr['result']['PowerKW'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['PowerKW'];
}

if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Cylinder']) && $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Cylinder']!=''){
$output_arr['result']['Cylinder'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Cylinder'];
}

if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Number_of_valves_per_cylinder']) && $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Number_of_valves_per_cylinder']!=''){
$output_arr['result']['Number_of_valves_per_cylinder'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Number_of_valves_per_cylinder'];
}

if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallID']) && count($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallID'])>0){
$output_arr['result']['RecallCarUKRecallID'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallID'];
}

if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallsCount']) && $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallsCount']!=''){
$output_arr['result']['RecallCarUKRecallsCount'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallsCount'];
}

if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallsNumber']) && $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallsNumber']!=''){
$output_arr['result']['RecallCarUKRecallsNumber'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['RecallCarUKRecallsNumber'];
}

if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Construction_from']) && $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Construction_from']!=''){
$output_arr['result']['Construction_from'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Construction_from'];
}else{
$output_arr['result']['Construction_from'] = date('Y');	
}

if(isset($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Construction_to']) && count($reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Construction_to'])>0){
$output_arr['result']['Construction_to'] = $reurned_array['soap:Body']['FindByRegistration']['Vehicle']['Construction_to'];
}else{
$output_arr['result']['Construction_to'] = date('Y');	
}



/* END - Start New Fields */


    if(isset($reurned_array['soap:Body']['soap:Fault']['faultstring']) && $reurned_array['soap:Body']['soap:Fault']['faultstring']!=''){
	unset($output_arr);	
	$output_arr['result']['message'] =$reurned_array['soap:Body']['soap:Fault']['detail']['FindByRegistration']['Error'];	
	$output_arr['status'] ='Failure';	
	}			 
						 
                	echo  json_encode($output_arr);
						exit ;
					} else {
						
						if($skipcheck == 0){
											
						$updateQuery = "UPDATE [automatch].[dbo].[MobileApp_Users] 
											SET [VRNUsed] = ISNULL([VRNUsed],0)+1 ".$appversion . $osversion . $devicename."
											WHERE [ClientID] = '" . $clientID . "' 
											AND [UserName] = '" . $username . "' 
											AND [UserPassword] = '" . $password . "' ";					
											
											
											
						$updateQuerySql = mssql_query_upgrade($updateQuery , dblink());
						$testtest = mssql_get_last_message_upgrade();
						$errorr = "Error";
						$subject = "$sname $errorr";
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
						$headers .= "From: Matchapart<noreply@matchapart.com>\r\n";
						$mih = "<font color='#FF0000' size='+1'>Sorry for the inconvenience, an unexpected error occured and we have been advised on this problem.<br><br>Service will resume soon, please try again later.<br><br>Thanks for your understanding</font>";
						if(!$updateQuerySql) {
							$msg .= "Error is on page " . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . "<br><br>
											Referral URL :" . $ref . "<br><br>
											User ID :" . $_SESSION['uid'] . "<br><br>
											Query :" . $updateQuery . "<br><br>
											Error :" . $testtest;
							if(@smtp_mail("alyons1880@googlemail.com" , $subject , $msg , $headers)) {
								die($mih);
								}
							}
						}
						$url = 'http://webserv.1stchoice.co.uk/1stchoiceservices/SupplierPub.asmx?op=RegnoLookup';
						$xmlsend = '<?xml version="1.0" encoding="UTF-8"?>';
						$xmlsend .= '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">';
						$xmlsend .= "<soap:Body>";
						$xmlsend .= '<RegnoLookup xmlns="1stChoice">';
						$xmlsend .= "<Username>d049</Username>";
						$xmlsend .= "<Password>scx873</Password>";
						$xmlsend .= "<regno>" . $vrn . "</regno>";
						$xmlsend .= "<usercode>DK</usercode>";
						$xmlsend .= "</RegnoLookup >";
						$xmlsend .= "</soap:Body>";
						$xmlsend .= "</soap:Envelope>";
						
						$output_arr['username'] ='d049';
						$output_arr['password'] ='scx873';
						$output_arr['regno'] = $vrn;
						$output_arr['usercode'] ='DK';
						
						$str = get_data($url , $xmlsend);
						$reurned_array = xml2array($str, $get_attributes=1, $priority = 'tag');
						//added by sanket 02-03-2016
						
						/*
						if(count($reurned_array['soap:Envelope']['soap:Body']['RegnoLookupResponse']) == 0){
							header("location:http://matchapart.com/script/mobileapp_ws_stockref_lookup.php?clientid=".$clientID."&searchby=".part."&stockref=".$vrn);
						}*/
						
						if(count($output_arr) == 0){
							/* header("location:http://matchapart.com/script/mobileapp_ws_stockref_lookup_json.php?clientid=".$clientID."&searchby=part&stockref=".$vrn); *//* Commented on 26-12-2019 on Ally Request*/
						}
						
						
						
						//header("content-type: text/xml");
						//echo $xmlsend;
						//echo $str;
						
						//$reurned_array = xml2array($str, $get_attributes=1, $priority = 'tag');
						//						exit;
					}
				} else {
					//header("content-type: text/xml");
					$xmlsend = '<?xml version="1.0" encoding="UTF-8"?>';
					$xmlsend .= "<Body>";
					//						$xmlsend 	.='<RegnoLookup xmlns="1stChoice">';
					$xmlsend .= "<Result>No Lookups Allowed for User</Result>";
					//						$xmlsend 	.="</RegnoLookup >";
					$xmlsend .= "</Body>";
					//echo $xmlsend;
					$output_arr['result'] ='No Lookups Allowed for User';
					$output_arr['status'] ='Failure';
					
					/*Commented on 20-03-2020 on request from Ally */
					/*header("location:http://matchapart.com/script/mobileapp_ws_stockref_lookup.php?clientid=".$clientID."&searchby=part&stockref=".$vrn);*/ 
					
					//exit;
				}
			} else {
				//header("content-type: text/xml");
				$xmlsend = '<?xml version="1.0" encoding="UTF-8"?>';
				$xmlsend .= "<Body>";
				$xmlsend .= "<Result>Failed Authorisation</Result>";
				$xmlsend .= "</Body>";
				$output_arr['result'] ='Failed Authorisation';
				$output_arr['status'] ='Failure';
				//echo $xmlsend;
			}
		}
	} else {
		//header("content-type: text/xml");
		$xmlsend = '<?xml version="1.0" encoding="UTF-8"?>';
		$xmlsend .= "<Body>";
		$xmlsend .= "<Result>Failed Authorisation</Result>";
		$xmlsend .= "</Body>";
		$output_arr['result'] ='Failed Authorisation';
		$output_arr['status'] ='Failure';
		//echo $xmlsend;
	}
	$clientId = $clientID;
	$username = $username;
	$sqlquery = $str_sql_select;
	$queryUpdate = $updateQuery;
	$xmlsend = $xmlsend;
	$scriptName = "mobileapp_ws_vrnlookup";
	$logFile = 'logs/'.$clientId . "_" . $username . "_" . $scriptName . "_" . date('mY') . '.txt';
	$logString = "";
	$fileOpen = fopen($logFile , 'a');
	$logString .= "\r\n /-----------------------" . date("d/m/Y H:i:s") . "-----------------------------------------/ \r\n	";
	$logString .= "\r\nURL 						: " . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
	$logString .= "\r\nClient ID 				: " . $clientId;
	$logString .= "\r\nUser Name 				: " . $username;
	$logString .= "\r\nUser Pass 				: " . $password;
	$logString .= "\r\nDevice ID 				: " . $deviceId;
	$logString .= "\r\nVRN		 				: " . $vrn;
	$logString .= "\r\nQuery Executed 			: " . $sqlquery;
	$logString .= "\r\nUpdate Query Executed	: " . $queryUpdate;
	//$logString .= "\r\nXML : " . $xmlsend;
	$logString .= "\r\nOutput : ".json_encode($output_arr);
	$logString .= "\r\n\r\n /----------------------------------------------------------------------------------/ \r\n	";
	$filewrite = fwrite($fileOpen , $logString);
	fclose($fileOpen);
	echo json_encode($output_arr);	
	mssql_close_new_upgrade();
?>