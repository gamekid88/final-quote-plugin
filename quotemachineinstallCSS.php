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
  * Creates the table to be used in this plugin.
  *
  * Creates the table with three columns. 
  *
  * @since 2.0

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