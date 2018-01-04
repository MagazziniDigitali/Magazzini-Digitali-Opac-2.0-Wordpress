<?php
include_once (MD_LOGIN_PATH . 'tools/wsdl/wsdlClient.php');
include_once (MD_LOGIN_PATH . 'tools/reCaptcha/reCaptcha.php');
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
		
		if (checkReCaptcha()){
			//print("SSSS:<BR\>");
			//print("J:".$_REQUEST ['j']."<br/>");
			$datiInput = json_decode ( decrypting ( $_REQUEST ['j'] ) );
			$userInput = $datiInput->userInput;
			//var_dump($datiInput);
	
			$typeAuth = $_REQUEST ['typeAuth'];
			// echo ('TypAuth: '.$typeAuth.'<br/>');
			if ($typeAuth == 'utente'){
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
			} else {
				$agentIdentifier = null;
				$agentName = null;
			}
			$authenticationUserOutput = confirmWsdlObject ( $userInput->objectIdentifier->objectIdentifierType,
					$userInput->objectIdentifier->objectIdentifierValue, $userInput->identifier, $userInput->actualFileName,
					$userInput->originalFileName, $userInput->tipoOggetto, $userInput->mimeType, $userInput->depositante, $typeAuth, $agentIdentifier, $agentName,
					$datiInput->rights->rightsIdentifier->rightsIdentifierType,
					$datiInput->rights->rightsIdentifier->rightsIdentifierValue,
					$datiInput->rights->rightsDisseminate->rightsDisseminateType, $_REQUEST ['login'], $_REQUEST ['password'] );
			checkResult($datiInput, $authenticationUserOutput);
		} else {
			md_Login_form ( $datiInput,  "&Egrave; necessario valorizzare tutti i campi");
		}
	} elseif (isset ( $_REQUEST ['id'] )) {
		$authenticationUserOutput = checkWsdlObject ( 'id', $_REQUEST ['id'] );
		checkResult($authenticationUserOutput, $authenticationUserOutput);
	} else {
		md_msgError ( 'Indicare le informazioni relative all\'oggetto da visionare' );
	}
	return ob_get_clean ();
}

function checkResult($datiInput, $output) {
	if (! empty ( $output->url )) { 
		md_showObject ( $output->url );
	} elseif (! empty($output->errorMsg) and
			! empty($output->errorMsg->msgError)) {
		md_Login_form ( $datiInput,  $output->errorMsg->msgError);
	} else {
		md_Login_form ( $datiInput);
	}
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
	if (get_option ( 'mdLoginAuthenticationRecaptcha', '0' ) == '1'){
		wp_register_script ( 'recaptcha-js', 'https://www.google.com/recaptcha/api.js' );
		wp_enqueue_script ( 'recaptcha-js' );
	}
	?>
<!-- 
	<script type="text/javascript">
	  var $MDUrl = '<?php echo(esc_url ( $_SERVER ['REQUEST_URI'] )); ?>;
	</script>
		<script data-main="<?php echo(plugins_url ( 'md-login/captcha/js/app' ))?>" src="<?php echo(plugins_url ( 'md-login/captcha/js/vendor/require.js' ))?>"></script>
 -->
<?php 	
	if (isset($msgError)){
		?>
		<div class="md_login_error_display">
		    <?php
			echo ($msgError);
			?>
		</div>
		<?php

	}
?>
<div class="tecaLoginForm">
  <form action="<?php echo(esc_url ( $_SERVER ['REQUEST_URI'] )); ?>" method="POST" id="tecaLoginForm" name="tecaLoginForm">
    <fieldset class="tecaLoginForm">
      <legend>Login Page</legend>
      <input type="hidden" name="j" value="<?php echo(crypting ( json_encode ( $authenticationUserOutput ) ))?>" />
      <div class="control-group">
        <div class="controls">
          <label class="inline" for="typeAuth">Tipo autenticazione:</label>
          <input class="normal text radio" type="radio" name="typeAuth" value="editore" onchange="changeTypeAuth(this);"/> editore
<?php 
    if (isset($authenticationUserOutput->agent)){
?>
          <input class="normal text radio" type="radio" name="typeAuth" value="utente"  onchange="changeTypeAuth(this);"/> utente
<?php 
    }
?>
        </div>
      </div>

      <div class="rHidden" id="istituto">
        <div class="controls">
          <label class="inline" for="istituto">Istituzione:</label>
          <select name="istituto" class="normal text select">
<?php 
  if (isset($authenticationUserOutput->agent)){
	if (is_array ( $authenticationUserOutput->agent )) {
	  foreach ( $authenticationUserOutput->agent as $key => $value ) {
?>
		    <option value="<?php echo($value->agentIdentifier)?>"><?php echo($value->agentName)?></option>
<?php 
      }
    } else {
    	?>
    	    <option value="<?php echo($authenticationUserOutput->agent->agentIdentifier)?>"><?php echo($authenticationUserOutput->agent->agentName)?></option>
    	<?php 
    }
  }
?>
          </select>
        </div>
      </div>

      <div class="rHidden" id="login">
        <div class="controls">
          <label class="inline" for="login">Login:</label>
          <input class="normal text input" type="text" name="login" value=""/>
        </div>
      </div>

      <div class="rHidden" id="password">
        <div class="controls">
          <label class="inline" for="password">Password:</label>
          <input class="normal text password" type="password" name="password" value=""/>
        </div>
      </div>
<!-- 
      <div class="rHidden" id="dCaptcha">
        <div class="controls">
          <label class="" for="captcha">Si prega di inserire il codice di verifica mostrato di seguito.</label>
          <div id="captcha-wrap">
            <img src="<?php echo(plugins_url ( 'md-login/captcha/img/refresh.jpg' ))?>" alt="ricarica captcha" id="refresh-captcha" /> 
            <img src="<?php echo(plugins_url ( 'md-login/captcha/php/newCaptcha.php' ))?>" alt="" id="captcha" />
          </div>
          <input class="narrow text input" id="captcha" name="captcha" type="text" placeholder="Codice di verifica"/>
        </div>
      </div>
 -->

      <div id="button" class="rHidden">
        <div class="controls">
<?php 
if (get_option ( 'mdLoginAuthenticationRecaptcha', '0' ) == '1'){
?>
	<div class="g-recaptcha" data-sitekey="<?php echo (get_option('mdLoginAuthenticationRecaptchaChiaveSito', ''))?>"></div>
<?php
}
?>
          <input class="btn primary" type="submit" value="Login"/>
        </div>
      </div>
	</fieldset>
  </form>
</div>
<?php 
}
?>
