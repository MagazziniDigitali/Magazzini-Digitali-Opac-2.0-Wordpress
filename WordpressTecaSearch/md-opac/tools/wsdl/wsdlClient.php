<?php
class WsdlExceptionOpac extends Exception {

}

function numberView($id){
	try {
		$urlWsdl = get_option ( 'NumberViewPortWsdl', 'default_value' );
		if ( $urlWsdl=='default_value'){
			$result= -1;
		} else {
			$gsearch = new SoapClient($urlWsdl);
	
			$params = array(
					'idObject' => $id);
			$result = $gsearch->NumberViewOperation($params);
		}
	} catch (SoapFault $e) {
		throw new WsdlExceptionOpac('Riscontrato un errore nella verifica Software ['.$e->getMessage().']');
	}
	return $result;
}
?>