<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();
  
global $wpdb;
$table_name = $wpdb->prefix . "erictable";
$sql = "DROP TABLE IF EXISTS ".$table_name;
$results = $wpdb->query( $sql );
?>
