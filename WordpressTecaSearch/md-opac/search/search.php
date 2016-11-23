<?php
include_once (MD_PLUGIN_PATH . 'show/show.php');
include 'searchResult.php';

/**
 * 
 */
function md_Search_form() {
	wp_register_style ( 'mdRicerca', plugins_url ( 'md-opac/css/MDRicerca.css' ) );
	wp_enqueue_style ( 'mdRicerca' );
	wp_register_style ( 'md', plugins_url ( 'md-opac/css/md.css' ) );
	wp_enqueue_style ( 'md' );
	
	wp_register_script ( 'gestText-js', plugins_url ( 'md-opac/js/gestText.js' ) );
	wp_enqueue_script ( 'gestText-js' );
	wp_register_script ( 'mdRicerca-js', plugins_url ( 'md-opac/js/MDRicerca.js' ) );
	wp_enqueue_script ( 'mdRicerca-js' );
	
	md_Search_Result ();
}

/**
 * 
 */
function md_View_form() {
	wp_register_style ( 'mdRicerca', plugins_url ( 'md-opac/css/MDRicerca.css' ) );
	wp_enqueue_style ( 'mdRicerca' );
	wp_register_style ( 'md', plugins_url ( 'md-opac/css/md.css' ) );
	wp_enqueue_style ( 'md' );

	wp_register_script ( 'mdRicerca-js', plugins_url ( 'md-opac/js/MDRicerca.js' ) );
	wp_enqueue_script ( 'mdRicerca-js' );

	md_View_Show ();
}

/**
 * 
 * @return string
 */
function cf_shortcode() {
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
	if (isset ( $_REQUEST ['view'] )) {
		if ($_REQUEST ['view'] == 'search') {
			md_Search_form ();
		} else if ($_REQUEST ['view'] == 'show') {
			md_View_form ();
		} else {
			md_Search_form ();
		}
	} else {
		md_Search_form ();
	}
	return ob_get_clean ();
}
?>
