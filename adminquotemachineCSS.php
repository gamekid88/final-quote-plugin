<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Eric's Quote Machine Next with CSS
Description: A plugin created to expand a little beyond the first quote plugin with added delete and list functionality.
			 Also this plugin will now have some CSS styling to add visibility and uniqueness. 
Version: 1.0
Author: Eric Rathmann
*/
include "includes/shortcode.php";
include "includes/quotemachineinstall.php";
include "includes/settingsquotemachine.php";
add_action('admin_menu', 'i_know_hooks');
register_activation_hook( __FILE__, 'activate_eric_quote_next');
add_action('init', 'check_update');
add_shortcode('eric_table_quote', 'table_quote_func');
add_shortcode('eric_random_revealed', 'random_quote_func');
wp_enqueue_style( 'ts_style', plugins_url('includes/main_css.css', __FILE__) );
wp_enqueue_script( 'newscript', plugins_url( '/js/main_js.js' , __FILE__ ));


function i_know_hooks()
{
	if (function_exists('add_menu_page'))
	{
		add_menu_page('Erics New Quote Machine', 'Erics New Quote Machine', 'moderate_comments', __FILE__, 'new_quote_machine');
	}
}


?>