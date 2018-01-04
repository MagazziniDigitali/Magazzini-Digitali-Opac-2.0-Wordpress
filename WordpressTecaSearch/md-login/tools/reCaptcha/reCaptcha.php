<?php

function checkReCaptchaURL($url){
	$result = false;
	$json = file_get_contents($url);
	$json_data = json_decode($json, true);
	if ($json_data["success"] == "true"){
		$result = true;
	} else {
		$result = false;
	}
//	var_dump($json_data);
	return $result;
}

function checkReCaptcha(){
	$result = false;
	if (get_option ( 'mdLoginAuthenticationRecaptcha', '0' ) == '0'){
		$result = true;
	} else if (get_option ( 'mdLoginAuthenticationRecaptcha', '0' ) == '1'){
		if (isset($_REQUEST['g-recaptcha-response']) and 
				!$_REQUEST['g-recaptcha-response'] ==""){
			$url = get_option ( 'mdLoginAuthenticationRecaptchaUrlValidate', '' );
			$url .= '?secret=' . get_option ( 'mdLoginAuthenticationRecaptchaChiaveSegreta', '' ) ;
			$url .= '&response=' . $_REQUEST['g-recaptcha-response'] ;
			$url .= '&remoteip=' . getIpClient();
			$result = checkReCaptchaURL($url);
		} else {
			$result = false;
		}
	}
	return $result;
}
?>