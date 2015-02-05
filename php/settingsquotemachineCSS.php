<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function new_quote_machine()
{
	wp_enqueue_script('eric_plugin_script', plugins_url( 'javascript/main_js.js', __FILE__ ));
	insert_quote();
	update_quote_table();
	load_quote();

}

/*
Function: insert_quote
Desc: This is the function that takes the variables from the text boxes converts them and then pass them both into an array of authors/quotes.
	  Also this will now pass a value of 0 for delete to be modified later. 
Parameters: savedQuote, savedAuthor, delete
Output: An array of quotes and authors 
*/


if ( current_user_can('moderate_comments') )
    {
                

    wp_nonce_field('nonce_check','nonce_field');  
    if (wp_verify_nonce( $_POST['nonce_field'], 'nonce_check'))
     {            
               
                
                
	function insert_quote()
	{	
	
            if(isset($_POST['savedQuote']) AND (isset($_POST['savedAuthor'])))	
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
            }//end if
	
	}//end function insertQuote
        
     }//end nonce check   
        

function check_update()
{
	$data = 1.0;
	if ( ! get_option('quote_plugin_version'))

            {

		add_option('quote_plugin_version' , $data);

            }

	elseif (get_option('quote_plugin_version') != $data)

            {

		//run update code

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
    wp_nonce_field('nonce_check','nonce_field');  
    if (wp_verify_nonce( $_POST['nonce_field'], 'nonce_check'))
     {   
	
	function update_quote_table ()
	{
		global $wpdb;
		$table_name = $wpdb->prefix."erictable";
	
		if(isset($_POST['delete_quote']))
		{
			$deleted_quote_id = sanitize_text_field($_POST["delete_quote_id"]);

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
		
		
		}//end if				
	
	}//end update_quote_table	
	
     }//end nonce check
	/*
Function: load_quote
Desc: This is a function that loads the quotes and authors from the database table into an html table. 
Parameters: savedQuote, savedAuthor, delete
Output: An array of quotes and authors 
*/
    wp_nonce_field('nonce_check','nonce_field');  
    if (wp_verify_nonce( $_POST['nonce_field'], 'nonce_check'))
     {   
	
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
			<td><form action="" method="post"><input type="hidden" name="delete_quote" value="confirmation" /><input type="hidden" name="delete_quote_id" 
			value="<?php echo esc_attr($value["quote_id"]); ?>" /><input type="submit" value="Delete" /></form></td>
                        <td><button onclick="edit_box();">Edit</button></td>
			<td><?php echo esc_attr($value["quote"]);?></td>
			<td><?php echo esc_attr(value["author"]); ?></td>
			</tr>
			

        <?php	} ?> 
	</table>
                
        

		<form action="" method="post">
		Please enter a quote: <input type="text" name="savedQuote"><br />   
		Pease enter the author: <input type="text" name="savedAuthor"><br />
		<input type="submit" value="Add Quote">
                <?php wp_nonce_field('nonce_check','nonce_field'); ?>
                <?php
                if (! wp_verify_nonce( $_POST['nonce_field'], 'nonce_check'))
                {
                    echo "Security Alert!";
                }
                ?>
                </form>
		<?php 
		
        }// end function load_quote
     }//end nonce check
     
     
        function edit_box()
        {?>

          <div id="dialog" title="Edit Quote">
              
        


        </div> 
  
        
            
            
            
            
      <?php  
         }//end edit_box
         
          }
        else
        {
            echo "This user is not allowed to moderate comments";
        }
      
      ?>