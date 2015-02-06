<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
Function: random_quote_func
Desc: This function creates the shortcode for my plugin. It pulls the results from the table 
	  together then strings them together wherever the end user wants the table to be shown.
	  Also this plugin adds some CSS to the table that is output. 
Parameters: atts
Output: Creates an html table for the results from the quote array.
*/
//
function table_quote_func($atts)
{
	wp_enqueue_style('eric_plugin_style', plugins_url( 'css/main_css.css', __FILE__ ));
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";
	
 	$eric_quote_array = $wpdb->get_results("SELECT * FROM $table_name WHERE deleted = 0","ARRAY_A");
		
	
	 $short_display_quote= my_css();
	 foreach ($eric_quote_array as $value) 
 	{ 	
 		
		$short_display_quote.="<p class='eric_container'>" .esc_html($value["quote"]) . "<span class= 'eric_author'>" .esc_html($value["author"]). "</span>"."</p>";			
	}//end for each loop
		
		return $short_display_quote;
 

}//end table_quote_func



/*
Function: random_quote_func
Desc: This shortcode function pulls the results from the table again but then randomly selects a
      quote and author and changes the properties of it via CSS and displays the updated table. 
Parameters: atts
Output: Creates an html table for the results from the quote array. Shows one quote and author with CSS. 
*/

function random_quote_func($atts)
{
	wp_enqueue_style('eric_plugin_style', plugins_url( 'css/main_css.css', __FILE__ ));
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";

	$eric_random_quote_array = $wpdb->get_row("SELECT * FROM $table_name WHERE deleted = 0 ORDER BY Rand() LIMIT 1","ARRAY_A");
	
	$short_random_quote = my_css();
	$short_random_quote.="<p class='eric_container'>" .esc_html($eric_random_quote_array["quote"]) . "<span class= 'eric_author'>" .esc_html($eric_random_quote_array["author"]). "</span>"."</p>";
	return $short_random_quote;
		

}//end random_quote_func

?>


