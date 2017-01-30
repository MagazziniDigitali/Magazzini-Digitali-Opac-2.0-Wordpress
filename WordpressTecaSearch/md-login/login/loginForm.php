<?php
include_once (MD_LOGIN_PATH . 'tools/wsdl/wsdlClient.php');
include_once (MD_LOGIN_PATH . 'tools/crypting.php');

/**
 *
 * @return string
 */
function md_login_page() {
	wp_register_style ( 'mdLogin', plugins_url ( 'md-login/css/mdLogin.css' ) );
	wp_enqueue_style ( 'mdLogin' );
	
	wp_register_script ( 'mdLogin-js', plugins_url ( 'md-login/js/mdLogin.js' ) );
	wp_enqueue_script ( 'mdLogin-js' );
	
	?>
<div class="breadcrumbs">
    <?php
	
	if (function_exists ( 'bcn_display' )) {
		bcn_display ();
	}
	?>
</div>
<?php
	ob_start ();
	if (isset ( $_REQUEST ['j'] )) {
		$datiInput = json_decode ( decrypting ( $_REQUEST ['j'] ) );
		$userInput = $datiInput->userInput;
		
		$agentIdentifier = $_REQUEST ['istituto'];
		if (is_array ( $datiInput->agent )) {
			foreach ( $datiInput->agent as $key => $value ) {
				if ($datiInput->agent [$key]->agentIdentifier == $agentIdentifier) {
					$agentName = $datiInput->agent [$key]->agentName;
				}
			}
		} else {
			if ($datiInput->agent->agentIdentifier == $agentIdentifier) {
				$agentName = $datiInput->agent->agentName;
			}
		}
		$authenticationUserOutput = confirmWsdlObject ( $userInput->objectIdentifier->objectIdentifierType, 
				$userInput->objectIdentifier->objectIdentifierValue, $userInput->identifier, $userInput->actualFileName, 
				$userInput->originalFileName, $agentIdentifier, $agentName, 
				$datiInput->rights->rightsIdentifier->rightsIdentifierType, 
				$datiInput->rights->rightsIdentifier->rightsIdentifierValue, 
				$datiInput->rights->rightsDisseminate->rightsDisseminateType, $_REQUEST ['login'], $_REQUEST ['password'] );
		if (! empty ( $authenticationUserOutput->url ) and 
				$authenticationUserOutput->rights->rightsDisseminate=='B') {
			md_showObject ( $authenticationUserOutput->url );
		} elseif (! empty ( $authenticationUserOutput->urlDocker )) {
			md_showDokerObject ( $authenticationUserOutput->url );
		} else {
			md_Login_form ( $datiInput,  $authenticationUserOutput->errorMsg->msgError);
		}
	} elseif (isset ( $_REQUEST ['id'] )) {
		$authenticationUserOutput = checkWsdlObject ( 'id', $_REQUEST ['id'] );
		if (! empty ( $authenticationUserOutput->errorMsg )) {
			md_msgError ( $authenticationUserOutput->errorMsg->msgError );
		} elseif (! empty ( $authenticationUserOutput->url ) and 
				$authenticationUserOutput->rights->rightsDisseminate=='B') {
			md_showObject ( $authenticationUserOutput->url );
		} elseif (! empty ( $authenticationUserOutput->url )) {
			md_showDokerObject ( $authenticationUserOutput->url );
		} else {
			md_Login_form ( $authenticationUserOutput , "");
		}
	} else {
		md_msgError ( 'Indicare le informazioni relative all\'oggetto da visionare' );
	}
	return ob_get_clean ();
}

function md_showDokerObject($url) {
	echo '<script type="text/javascript">';
	echo 'function mdLoginDoRedirect() {';
	echo 'document.docker.submit(); = "' . $url . '";';
	echo '}';
	echo 'window.setTimeout("mdLoginDoRedirect()", 5000);';
	echo '</script>';
	echo '<div class="tecaLoginForm">';
	echo '<p>Tra pochi secondi verrà aperta la pagina dell\'oggetto richiesto</p>';
	echo '<p>altrimenti puoi utilizzare questo <a href="' . $url . '">link</a>	</p>';
	echo '<form Method="POST" name="docker" action="'.get_option ( 'mdLoginAuthenticationDockerURL', '' ).'"><input type="hidden" name="url" value="'.$url.'"/></form>';
	echo '</div>';
}

function md_showObject($url) {
	echo '<script type="text/javascript">';
	echo 'function mdLoginDoRedirect() {';
	echo 'location.href = "' . $url . '";';
	echo '}';
	echo 'window.setTimeout("mdLoginDoRedirect()", 5000);';
	echo '</script>';
	echo '<div class="tecaLoginForm">';
	echo '<p>Tra pochi secondi verrà aperta la pagina dell\'oggetto richiesto</p>';
	echo '<p>altrimenti puoi utilizzare questo <a href="' . $url . '">link</a>	</p>';
	echo '</div>';
}

function md_msgError($msgErr) {
	echo '<div class="tecaLoginForm">';
	echo '<h1>' . $msgErr . '</h1>';
	echo '</div>';
}

function md_Login_form($authenticationUserOutput, $msgError) {
	if (isset($msgError)){
		?>
		<div class="md_login_error_display">
		    <?php
			echo ($msgError);
			?>
		</div>
		<?php
				
	}
	echo '<div class="tecaLoginForm">';
	echo '  <form action="' . esc_url ( $_SERVER ['REQUEST_URI'] ) . '" method="GET" id="tecaLoginForm" name="tecaLoginForm">';
	echo '    <fieldset class="tecaLoginForm">';
	echo '      <input type="hidden" name="j" value="' . crypting ( json_encode ( $authenticationUserOutput ) ) . '" />';
	echo '      <legend>Login Page</legend>';
	echo '      <table id="tecaLoginForm">';
	echo '		  <tr><th>Istituzione:</th><td><select name="istituto">';
	if (is_array ( $authenticationUserOutput->agent )) {
		foreach ( $authenticationUserOutput->agent as $key => $value ) {
			echo '<option value="' . $value->agentIdentifier . '">' . $value->agentName . '</option>';
		}
	} else {
		echo '<option value="' . $authenticationUserOutput->agent->agentIdentifier . '">' . $authenticationUserOutput->agent->agentName . '</option>';
	}
	echo '</select></td></tr>';
	echo '        <tr><th>Login:</th><td><input class="defaultText" title="Login:" type="text" name="login" value=""/></td></tr>';
	echo '        <tr><th>Pasword:</th><td><input class="defaultText" title="Password:" type="password" name="password" value=""/></td></tr>';
	echo '        <tr><th colspan="2"><input type="button" value="Login" onclick="cerca();"/></td></tr>';
	echo '      </table>';
	echo '    </fieldset>';
	echo '  </form>';
	echo '</div>';
}
?>