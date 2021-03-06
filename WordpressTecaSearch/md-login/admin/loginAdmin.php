<?php
function md_login_admin_setup_menu() {
	add_menu_page ( 'MD-Login', 'Magazzini Digitali Login', 'manage_options', 'md-Login', 'md_Login_Auth_Software' );
	add_submenu_page ( 'md-Login', 'crypting', 'Codifica', 'activate_plugins', 'md-Login-Codifica', 'md_Login_Codifica' );
	add_submenu_page ( 'md-Login', 'docker', 'Docker', 'activate_plugins', 'md-Login-Docker', 'md_Login_Docker' );
	add_submenu_page ( 'md-Login', 'recaptcha', 'reCaptcha', 'activate_plugins', 'md-Login-Recaptcha', 'md_Login_Recaptcha' );
	}

function md_Login_Recaptcha() {
		$createForm = new CreateForm ();
		$options = array (
				array (
						"name" => "Recaptcha",
						"id" => "mdLoginAuthenticationRecaptcha",
						"type" => "radio",
						"desc" => "Viene utilizzato per abilitare la verifica Recaptcha",
						"options" => array (
								"0" => "No",
								"1" => "Si"
						),
						"parent" => "header-styles",
						"std" => "0"
				),
				array (
						"name" => "URL Validazione",
						"desc" => "URL per la validazione e autenticazione dei Recaptcha",
						"id" => "mdLoginAuthenticationRecaptchaUrlValidate",
						"type" => "text",
						"parent" => "header-styles",
						"std" => ""
				),
				array (
						"name" => "Chiave del Sito",
						"desc" => "Password per la validazione e autenticazione dei Recaptcha",
						"id" => "mdLoginAuthenticationRecaptchaChiaveSito",
						"type" => "text",
						"parent" => "header-styles",
						"std" => ""
				),
				array (
						"name" => "Chiave segreta",
						"desc" => "Password per la validazione e autenticazione dei Recaptcha",
						"id" => "mdLoginAuthenticationRecaptchaChiaveSegreta",
						"type" => "text",
						"parent" => "header-styles",
						"std" => ""
				)
		);
		?>
			<div class="wrap">
				<h1>Gestione dati per l'interfaccia Docker</h1>
				<div class="mnt-options">
			<?php
				$createForm->create_form ( $options );
				?>
			    </div>
			</div>
			<?php
			
	}
		
function md_Login_Docker() {
	$createForm = new CreateForm ();
	$options = array (
			array (
					"name" => "URL Docker",
					"desc" => "URL interfaccia Docker",
					"id" => "mdLoginAuthenticationDockerURL",
					"type" => "text",
					"parent" => "header-styles",
					"std" => ""
			)
	);
	?>
		<div class="wrap">
			<h1>Gestione dati per l'interfaccia Docker</h1>
			<div class="mnt-options">
		<?php
			$createForm->create_form ( $options );
			?>
		    </div>
		</div>
		<?php
		
}

function md_Login_Codifica(){
	$createForm = new CreateForm ();
	$options = array (
			array (
					"name" => "Secret Key",
					"desc" => "Indicare la Secret Key",
					"id" => "mdLoginAuthenticationPasswordCodifica",
					"type" => "text",
					"parent" => "header-styles",
					"std" => ""
			),
			array (
					"name" => "Secret Iv",
					"desc" => "Indicare la Secret Iv",
					"id" => "mdLoginAuthenticationPasswordIv",
					"type" => "text",
					"parent" => "header-styles",
					"std" => ""
			)
	);
	?>
	<div class="wrap">
		<h1>Gestione dati per la Codifica</h1>
		<div class="mnt-options">
	<?php
		$createForm->create_form ( $options );
		?>
	    </div>
	</div>
	<?php
}

/**
 */
function md_Login_Auth_Software() {
	$createForm = new CreateForm ();
	$options = array (
			array (
					"name" => "URL Autenticazione Software",
					"desc" => "Indicare il nome del Server Autenticazione Software",
					"id" => "mdLoginAuthenticationSoftwareUrl",
					"type" => "text",
					"parent" => "header-styles",
					"std" => ""
			),
			array (
					"name" => "Login Autenticazione Software",
					"desc" => "Indicare il Login Server Autenticazione Software",
					"id" => "mdLoginAuthenticationSoftwareLogin",
					"type" => "text",
					"parent" => "header-styles",
					"std" => ""
			),
			array (
					"name" => "Password Autenticazione Software",
					"desc" => "Indicare la password del Server Autenticazione Software",
					"id" => "mdLoginAuthenticationSoftwarePassword",
					"type" => "text",
					"parent" => "header-styles",
					"std" => ""
			)
	);
	?>
<div class="wrap">
	<h1>Configurazione collegamento server di Autenticazione Software</h1>
	<div class="mnt-options">
<?php
	$createForm->create_form ( $options );
	?>
    </div>
</div>
<?php
}

?>