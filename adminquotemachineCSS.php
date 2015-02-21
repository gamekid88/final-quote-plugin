<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Eric's Quote Machine Next with CSS
Description: A plugin created to expand a little beyond the first quote plugin with added delete and list functionality.
			 Also this plugin will now have some CSS styling to add visibility and uniqueness. 
Version: 1.0
Author: Eric Rathmann
*/
include "php/shortcode.php";
include "quotemachineinstall.php";
include "php/settingsquotemachine.php";
add_action('admin_menu', 'i_know_hooks');
register_activation_hook( __FILE__, 'activate_eric_quote_next');
add_action('init', 'check_update');
add_shortcode('eric_table_quote', 'table_quote_func');
add_shortcode('eric_random_revealed', 'random_quote_func');
add_shortcode('group_quote', 'group_quote_func');

function i_know_hooks()
{
	if (function_exists('add_menu_page'))
	{
		add_menu_page('Erics New Quote Machine', 'Erics New Quote Machine', 'moderate_comments', __FILE__, 'new_quote_machine');
	}
}


?>
