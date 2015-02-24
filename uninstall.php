<?php
/**
 * 
 *

 * @package     EQM
 * @copyright   Copyright (c) 2014, Eric Rathmann
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0

*/



//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();
  
global $wpdb;
$table_name = $wpdb->prefix . "erictable";
$sql = "DROP TABLE IF EXISTS ".$table_name;
$results = $wpdb->query( $sql );
?>
