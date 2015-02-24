<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* Plugin Name: Eric's New Quote Machine
* Description: This plugin will allow you to enter a quote and author into a form and then it will display everything in a database.
* There is also added delete and edit functionality to manipulate the quotes once they have been entered.
* Version: 2.0
* Author: Eric Rathmann
* Author URI: http://www.mylocalwebstop.com/
* Plugin URI: http://www.mylocalwebstop.com/
* Text Domain: my-plugin
* Domain Path: /languages
*
* @author Eric Rathmann

* @version 2.0

*/
include "php/shortcode.php";
include "quotemachineinstallCSS.php";
include "php/settingsquotemachineCSS.php";
add_action('admin_menu', 'i_know_hooks');
register_activation_hook( __FILE__, 'activate_eric_quote_next');
add_action('init', 'check_update');
add_action( 'plugins_loaded', 'my_plugin_load_plugin_textdomain' );
add_shortcode('eric_table_quote', 'table_quote_func');
add_shortcode('eric_random_revealed', 'random_quote_func');
add_shortcode('group_quote', 'group_quote_func');


/**
  * Adds the admin file to the side and allows rest of the plugin to work
  *
  * @since 2.0

*/
function i_know_hooks()
{
	if (function_exists('add_menu_page'))
	{
         add_menu_page('Erics New Quote Machine', 'Erics New Quote Machine', 'moderate_comments', __FILE__, 'new_quote_machine');
	}
}


/**
  * This function loads the plugin domain so that it can be used in translation.
  *
  * @since 2.0
 */
function my_plugin_load_plugin_textdomain()
{
        load_plugin_textdomain( 'my-plugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}


?>
