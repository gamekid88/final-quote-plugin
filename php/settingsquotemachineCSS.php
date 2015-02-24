<?php
/**
 * @package     EQM
 * @copyright   Copyright (c) 2014, Eric Rathmann
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

/**
  * This the functionality order that the plugin uses. 
  *
  * Allows the plugin to run properly by running the functions in the listed order
  *
  * @since 2.0
  */
if ( ! defined( 'ABSPATH' ) ) exit;
function new_quote_machine()
{
	if ( current_user_can('moderate_comments') )
	{
		?>
		<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" />
		<?php
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script('eric_plugin_script', plugins_url( 'javascript/main_js.js', __FILE__ ));
		insert_quote();
		update_quote_table();
		update_edit_quote();
		load_quote();
	}
}

/**
 * This is the function that enters the quote and author into the database. 
 * 
 * @since 2.0
 */
function insert_quote()
{
    if(isset($_POST['savedQuote']) AND (isset($_POST['savedAuthor'])))	
    {
    	if (wp_verify_nonce( $_POST['nonce_field'], 'nonce_check'))
	 	{ 
			global $wpdb;
			$table_name = $wpdb->prefix."erictable";
			$quote = sanitize_text_field($_POST['savedQuote']);
			$author = sanitize_text_field($_POST['savedAuthor']);
			$delete = 0;
		
			$wpdb->insert( 
				$table_name, 
				array( 
				'quote' => $quote, 
				'author' =>$author,
				'deleted' =>$delete
			));
	 	}
    }//end if

}//end function insertQuote
        
/**
  * This the update function that will be used if the plugin is updated. 
  *
  * @since 2.0
  */
function check_update()
{
	$data = 1.0;
	if ( ! get_option('quote_plugin_version'))
	{
		add_option('quote_plugin_version' , $data);
	}
	elseif (get_option('quote_plugin_version') != $data)
	{
		update_option('quote_plugin_version' , $data);
	}
}
	
	
/**
  * This is the function that is used to remove a quote and author
  *
  * When the user clicks the delete button it will remove the selected quote and author from the table. * 
  * 
  * @since 2.0
  */ 
function update_quote_table ()
{
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";

	if(isset($_POST['delete_quote']))
	{
		if (wp_verify_nonce( $_POST['nonce_field'], 'nonce_check'))
 		{
			$deleted_quote_id = intval($_POST["delete_quote_id"]);
	
			$wpdb->update( 
				$table_name, 
				array( 
					'deleted' => 1 
				), 
				array( 'quote_id' => $deleted_quote_id ),  
				array( 
					'%d' 
				), 
				array( '%d' ) 
			);
 		}
	}//end if				

}//end update_quote_table	
	
/**
  * This the function that will load the quotes and authors and displays it for the admin
  *
  * This also creates the button that is used in the edit functionality. 
  * When the user clicks the edit it will load a dialog that the user can then edit the selected
  * quote and author. This function also includes the form for entering the initial quote and author. 
  * 
  * @since 2.0
  */
function load_quote()
{
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";
	
	$eric_quote_array = $wpdb->get_results("SELECT * FROM $table_name WHERE deleted = 0","ARRAY_A");?>
	
	<h2><?php _e('Quotes and their Authors','my-plugin');?></h2>
	<table>
	<?php 
	foreach ($eric_quote_array as $value) 
	{ 
		?>
		<tr>
			<td>
				<form action="" method="post"><input type="hidden" name="delete_quote" value="confirmation" />
					<input type="hidden" name="delete_quote_id" value="<?php echo esc_attr($value["quote_id"]); ?>" />
					<input type="submit" value= <?php _e('Delete','my-plugin');?> />
					<?php wp_nonce_field('nonce_check','nonce_field'); ?>
				</form>
			</td>
			<td><button onclick="show_popup(<?php echo $value["quote_id"]; ?>);">Edit</button></td>
			<td><?php echo esc_html($value["quote"]);?></td>
			<td><?php echo esc_html($value["author"]); ?></td>
			<div style =" display:none;" id="dialog<?php echo$value["quote_id"]; ?>" title=<?php _e('Edit Quote','my-plugin');?>>
				<form action="" method="post"><input type="hidden" name="hid_edit_quote" value="confirmation" />
					<input type="hidden" name="hid_edit_quote_id" value="<?php echo esc_attr($value["quote_id"]); ?>" />
					<?php _e('Please edit the quote:','my-plugin')?> <input type= "text" name="editQuote" value= "<?php echo $value["quote"]; ?>" ><br />   
					<?php _e('Please edit the author:','my-plugin')?> <input type= "text" name="editAuthor" value="<?php echo $value["author"];?>"><br />
					<input type="submit" name="submit_edit" value=<?php _e('Submit Edit','my-plugin');?>>
				</form>
			</div> 
		</tr>
		<?php
	} 
	?> 
	</table>
	<form action="" method="post">
		<?php _e('Please enter a quote:','my-plugin')?> <input type="text" name="savedQuote"><br />   
		<?php _e('Please enter the author:','my-plugin')?> <input type="text" name="savedAuthor"><br />
		<input type="submit" value="<?php _e('Add Quote','my-plugin');?>"/>
		<?php wp_nonce_field('nonce_check','nonce_field'); ?>
	</form>
	<?php 
}// end function load_quote


/**
  * This is the function that updates the database when the edit is confirmed. 
  *
  * @since 2.0
  */
function update_edit_quote()
{
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";
	if (isset($_POST["hid_edit_quote_id"]))
	{
		$quote_id = intval($_POST["hid_edit_quote_id"]);
		$quote = sanitize_text_field($_POST["editQuote"]);
		$author = sanitize_text_field($_POST["editAuthor"]);
		
		$results = $wpdb->update(
			$table_name,
			array(
				'quote' => $quote,
				'author' => $author
			),
			array(
				'quote_id' => $quote_id
			),
			array(
				'%s',
				'%s'
			),
			array(
				'%d'
			)
		);
		
		if ($results != false)
		{
			_e('Quote has been updated!','my-plugin');
		}
	}
}//end function update_edit_quote
?>
