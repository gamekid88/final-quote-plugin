<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function new_quote_machine()
{
	if ( current_user_can('moderate_comments') )
    	{
		wp_enqueue_script('eric_plugin_script', plugins_url( 'javascript/main_js.js', __FILE__ ));
		insert_quote();
		update_quote_table();
		load_quote();
    	}
}

/*
Function: insert_quote
Desc: This is the function that takes the variables from the text boxes converts them and then pass them both into an array of authors/quotes.
	  Also this will now pass a value of 0 for delete to be modified later. 
Parameters: savedQuote, savedAuthor, delete
Output: An array of quotes and authors 
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
	
	
		/*
Function: update_quote_table
Desc: This is a function that updates the table when the delete button is pressed. A value of 1 is
	  passed into the delete value and the table is then reupdated to show the table without the quote that was deleted.	  	
Parameters: delete_quote, delete_quote_id
Output: An updated table of quotes and authors 
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
	
	/*
Function: load_quote
Desc: This is a function that loads the quotes and authors from the database table into an html table. 
Parameters: savedQuote, savedAuthor, delete
Output: An array of quotes and authors 
*/

	function load_quote()
 	{
	global $wpdb;
	$table_name = $wpdb->prefix."erictable";
	
	 $eric_quote_array = $wpdb->get_results("SELECT * FROM $table_name WHERE deleted = 0","ARRAY_A");?>
         
	<h2>Quotes and their Authors</h2>
	<table>
	<?php foreach ($eric_quote_array as $value) 
		{ ?>
			<tr>
			<td>
				<form action="" method="post"><input type="hidden" name="delete_quote" value="confirmation" />
					<input type="hidden" name="delete_quote_id" value="<?php echo esc_attr($value["quote_id"]); ?>" />
					<input type="submit" value="Delete" />
					<?php wp_nonce_field('nonce_check','nonce_field'); ?>
				</form>
			</td>
                <td><button onclick="show_popup(<?php echo $value["quote_id"]; ?>">Edit</button></td>
                        <div style =" display:none;" id="dialog<?php echo$value["quote_id"]; ?>" title="Edit Quote">
                          
                            <form action="" method="post">
                                Please edit the quote: <input type= "text" name="editQuote" value= "<?php echo $value["quote"]; ?>" ><br />   
                                Please edit the author: <input type= "text" name="editAuthor" value="<?php echo $value["author"];?>"><br />
                            <input type="submit" value="Submit Edit">
                            </form>


                         </div> 
			<td><?php echo esc_html($value["quote"]);?></td>
			<td><?php echo esc_html($value["author"]); ?></td>
			</tr>
        <?php	} ?> 
	</table>
                
        

		<form action="" method="post">
		Please enter a quote: <input type="text" name="savedQuote"><br />   
		Please enter the author: <input type="text" name="savedAuthor"><br />
		<input type="submit" value="Add Quote">
                <?php wp_nonce_field('nonce_check','nonce_field'); ?>
                </form>
		<?php 
		
        }// end function load_quote
     
   
          
        
      
      ?>
