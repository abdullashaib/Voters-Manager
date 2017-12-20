<?php


function delete_tables() {

  if( !defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') ) {
  	exit();
  } else {
  
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
  	global $wpdb;
  	
  	// drop the tables
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "constituency";
  	$wpdb->query($sql);
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "districts";
  	$wpdb->query($sql);
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "island";
  	$wpdb->query($sql);
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "roles";
  	$wpdb->query($sql);
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "pollingstation_shehia";
  	$wpdb->query($sql);
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "pollingstation_word";
  	$wpdb->query($sql);
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "regions";
  	$wpdb->query($sql);  
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "pollingstations";
  	$wpdb->query($sql);  
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "shehia";
  	$wpdb->query($sql);  
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "words";
  	$wpdb->query($sql);  
  	$sql = "DROP TABLE if exists " . $wpdb->prefix . "voters";
  	$wpdb->query($sql);  
  }
  
}

?>
