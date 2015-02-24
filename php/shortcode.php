<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 
 *

 * @package     EQM
 * @copyright   Copyright (c) 2014, Eric Rathmann
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0

*/
/**
  * This is the shortcode that displays all of the quotes and authors that the admin has entered.
  *
  * @param array $atts Used to pass the results back to the website
 *  
  * @return $short_display_quote 
  * @since 2.0
 * 
 */
function table_quote_func($atts)
{
	wp_enqueue_style('eric_plugin_style', plugins_url( 'css/main_css.css', __FILE__ ));
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";
	
 	$eric_quote_array = $wpdb->get_results("SELECT * FROM $table_name WHERE deleted = 0","ARRAY_A");
		
	 foreach ($eric_quote_array as $value) 
 	{ 	
 		
		$short_display_quote.="<p class='eric_container'>" .esc_html($value["quote"]) . "<span class= 'eric_author'>" .esc_html($value["author"]). "</span>"."</p>";			
	}//end for each loop
		
		return $short_display_quote;
 

}//end table_quote_func



/**
  * This shortcode displays a random quote for the website user.
  *
  * @param array $atts Used to return the array to the website.
  *
  * @since 2.0
 * 
 */

function random_quote_func($atts)
{
	wp_enqueue_style('eric_plugin_style', plugins_url( 'css/main_css.css', __FILE__ ));
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";

	$eric_random_quote_array = $wpdb->get_row("SELECT * FROM $table_name WHERE deleted = 0 ORDER BY Rand() LIMIT 1","ARRAY_A");

	$short_random_quote.="<p class='eric_container'>" .esc_html($eric_random_quote_array["quote"]) . "<span class= 'eric_author'>" .esc_html($eric_random_quote_array["author"]). "</span>"."</p>";
	return $short_random_quote;
		

}//end random_quote_func

/**
  * This shortcode returns all quotes/authors by a certain author
  *
  * @param array $atts Used to return the array for displaying. 
  *
  * @since 2.0
 * 
 */



function group_quote_func($atts)
{
        wp_enqueue_style('eric_plugin_style', plugins_url( 'css/main_css.css', __FILE__ ));
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";
        
        extract(shortcode_atts(array(
        'group_name'=> '0'    
        ), $atts));
                
        $group_name_var = sanatize_text_field($group_name);
        
        
        $eric_group_quote_array = $wpdb->get_results($wpdb->prepare("SELECT * FROM  WHERE $table_name author=%s", $group_name_var));
        
        foreach ($eric_group_quote_array as $value)
        {
        $short_group_quote.="<p class='eric_container'>" .esc_html($value["quote"]) . "<span class= 'eric_author'>" .esc_html($value["author"]). "</span>"."</p>";
        }
        return $short_group_quote;
    
    
}// end group_quote_func
?>


