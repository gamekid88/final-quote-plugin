<?php
global $wpdb;

$table_name = $wpdb->prefix . "erictable";

$sql = "DROP TABLE IF EXISTS ".$table_name;

$results = $wpdb->query( $sql );


?>