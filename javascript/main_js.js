/**
 * @package     EQM
 * @copyright   Copyright (c) 2014, Eric Rathmann
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0
*/

/**
 * Used to create the dialog box that is used within the settings file.
 * Generates the content for the end section of the quiz page
 *
 * @since 2.0
 * @param id This is the id of the quote that is pulled from the database.
*/
    
function show_popup(id)
{
	var $j = jQuery.noConflict();
	$j( "#dialog".id ).dialog();
}
