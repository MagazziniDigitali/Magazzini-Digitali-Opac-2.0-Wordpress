<?php
/*
Plugin Name: Magazzini Digitali - Login
Version: 2.0.8
Description: Interfaccia Login per Magazzini Digitali
Author: Massimiliano Randazzo
Author URI: http://www.depositolegale.it
*/
define( 'MD_LOGIN_PATH', plugin_dir_path( __FILE__ ) );

include(MD_LOGIN_PATH.'login/loginForm.php');
include(MD_LOGIN_PATH.'admin/loginAdmin.php');
/*
define( 'MD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
*/

add_shortcode( 'md_login_page_form', 'md_login_page' );
add_action('admin_menu', 'md_login_admin_setup_menu');


?>
