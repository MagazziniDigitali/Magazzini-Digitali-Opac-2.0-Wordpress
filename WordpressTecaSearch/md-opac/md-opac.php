<?php
/*
Plugin Name: Magazzini Digitali - Opac
Version: 2.0.5
Description: Intrfacci Opac per Magazzini Digitali
Author: Massimiliano Randazzo
Author URI: http://www.depositolegale.it
*/
define( 'MD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
include(MD_PLUGIN_PATH.'search/search.php');
include(MD_PLUGIN_PATH.'admin/admin.php');

add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );

add_action('admin_menu', 'md_plugin_setup_menu');

?>
