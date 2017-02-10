<?php
class WsdlException extends Exception {

}

function authenticationSoftware(){
	try {
		$gsearch = new SoapClient(get_option ( 'mdLoginAuthenticationSoftwareUrl', 'default_value' ));

		$params = array(
				'login' => get_option ( 'mdLoginAuthenticationSoftwareLogin', 'default_value' ),
				'password' => hash("sha256", get_option ( 'mdLoginAuthenticationSoftwarePassword', 'default_value' )));
		$result = $gsearch->AuthenticationSoftwareOperation($params);
	} catch (SoapFault $e) {
		throw new WsdlException('Riscontrato un errore nella verifica Software ['.$e->getMessage().']');
	}
	return $result;
}

function checkWsdlObject($objectIdentifierType, $objectIdentifierValue){
	try{
		$software = authenticationSoftware();
		$gsearch = new SoapClient(readParameter($software, 'AuthenticationUserLibraryPort'));

		//    var_dump($gsearch->__getFunctions());
		//   var_dump($gsearch->__getTypes());
		//   print ("<br/>ESEGUO<br/>");

		// print ("<br/>ESEGUO AAAAAA<br/>");
		$params = array(
				'userInput' => array(
						'objectIdentifier' => array (
								'objectIdentifierType' => $objectIdentifierType,
								'objectIdentifierValue' => $objectIdentifierValue),
						'software' => $software,
						'ipClient' => getIpClient()
				));

		$result = $gsearch->AuthenticationUserLibraryOperation($params);
		// print ("<br/>ESEGUO<br/>");
		// print ($result);

	} catch (SoapFault $e) {
		throw new WsdlException('Riscontrato un errore nella verifica dell\'oggetto ['.$e->getMessage().']');
	} catch (WsdlException $e){
		throw $e;
	}
	return $result;
}

function confirmWsdlObject($objectIdentifierType, $objectIdentifierValue, $identifier, $actualFileName,
		$originalFileName, $agentIdentifier, $agentName, $rightsIdentifierType, $rightsIdentifierValue,
		$rightsDisseminateType, $login, $password){
			try{
				$software = authenticationSoftware();
				$gsearch = new SoapClient(readParameter($software, 'AuthenticationUserLibraryPort'));

				//    var_dump($gsearch->__getFunctions());
				//   var_dump($gsearch->__getTypes());
				//   print ("<br/>ESEGUO<br/>");

				$params = array(
						'userInput' => array(
								'objectIdentifier' => array (
										'objectIdentifierType' => $objectIdentifierType,
										'objectIdentifierValue' => $objectIdentifierValue
								),
								'software' => $software,
								'ipClient' => getIpClient(),
								'identifier' => $identifier,
								'actualFileName' => $actualFileName,
								'originalFileName' => $originalFileName,
								'agent' => array(
										'agentIdentifier' => $agentIdentifier,
										'agentName' => $agentName
								),
								'rights' => array(
										'rightsIdentifier' => array(
												'rightsIdentifierType' => $rightsIdentifierType,
												'rightsIdentifierValue' => $rightsIdentifierValue
										),
										'rightsDisseminate' => array(
												'rightsDisseminateType' => $rightsDisseminateType
										)
								),
								'authentication' => array(
										'login' => $login,
										'password' => $password
								)
						));

				$result = $gsearch->AuthenticationUserLibraryOperation($params);
				// var_dump($result->rights);

			} catch (SoapFault $e) {
				throw new WsdlException('Riscontrato un errore nella verifica dell\'oggetto ['.$e->getMessage().']');
			} catch (WsdlException $e){
				throw $e;
			}
			return $result;
}

function readParameter($software, $key){
	$result='';

	if (!empty($software->softwareConfig)){
		if (is_array($software->softwareConfig)){
			foreach($software->softwareConfig as $key => $value){
				if ($software->softwareConfig[$key]->nome == $key){
					$result = $software->softwareConfig[$key]->value;
				}
			}
		} else {
			if ($software->softwareConfig->nome == $key){
				$result = $software->softwareConfig->value;
			}
		}
	}
	return $result;
}
function getIpClient(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
?>