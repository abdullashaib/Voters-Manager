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


/*
 *  This function will be used to delete all pages created during plugin activation. It will also 
 *  delete all postmeta from postmeta table for those page that has custom template to display 
 */ 
function delete_pages_postmeta() {

  global $wpdb;
  
  $pages = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "plugin_pages");
  
  foreach ( $pages as $page ) 	{           
     $page_title = get_page_by_title($page->title);    
     // delete page permanently
     wp_delete_post($page_title->ID, true) ; 
     
     // Delete postmeta
     delete_post_meta($page_title->ID, '_wp_page_template', $page->template);        
  }

}

?>
