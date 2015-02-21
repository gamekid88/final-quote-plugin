<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
Function: activate_eric_quote
Desc: This function creates the table within the database in Wordpress. 
Parameters: None
Output: A table within the datebase to be used.
*/
function activate_eric_quote_next ()
{
global $wpdb;


$table_name = $wpdb->prefix . "erictable"; 
$sql = "CREATE TABLE $table_name (
quote_id mediumint(9) NOT NULL AUTO_INCREMENT,
quote text NOT NULL,
author text NOT NULL,
deleted INT NOT NULL, 
UNIQUE KEY quote_id (quote_id)
)";


require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

dbDelta( $sql );
}









?>