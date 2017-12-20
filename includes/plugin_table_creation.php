<?php

function create_db_tables() {


  global $wpdb;
  
  $charset_collate = $wpdb->get_charset_collate();
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  
  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "constituency (
      id int(10)  NOT NULL,
      constituency VARCHAR(255) NOT NULL UNIQUE,
      district_id int(5) NOT NULL,
      updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);
  


  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "districts (
      id int(10)  NOT NULL,
      name VARCHAR(255) NOT NULL UNIQUE,
      region_id int(5) NOT NULL,
      updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);      
  
  
  
  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "island (
      id int(10)  NOT NULL,
      name VARCHAR(255) NOT NULL UNIQUE,
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);
  
  
  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "roles (
      id int(10)  NOT NULL,
      name VARCHAR(255) NOT NULL UNIQUE,
      description   VARCHAR(255), 
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);
  
  
  
  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "pollingstation_shehia (
      id int(10)  NOT NULL,
      shehia_id          int(10) NOT NULL,
      pollingstation_id  int(10) NOT NULL,
      word_id            int(10) NOT NULL,
      constituency_id    int(10) NOT NULL,
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);

   
   
  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "pollingstation_word (
      id int(10)  NOT NULL,
      pollingstation_id  int(10) NOT NULL,
      word_id          int(10) NOT NULL,
      constituency_id    int(10) NOT NULL,
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);
  
  
  
  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "regions (
      id int(10)  NOT NULL,
      name VARCHAR(255) NOT NULL UNIQUE,
      isand_id int(5) NOT NULL,
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);



  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "pollingstations (
      id int(10)  NOT NULL,
      name VARCHAR(255) NOT NULL,
      number    int(10),
      shehia_id int(5) NOT NULL,
      constituency_id int(5) NOT NULL,
      updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);
  


  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "shehia (
      id int(10)  NOT NULL,
      name VARCHAR(255) NOT NULL,
      word_id int(5) NOT NULL,
      constituency_id int(5) NOT NULL, 
      residents       int(25),
      registered      int(25),
      updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);
  


  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "words (
      id int(10)  NOT NULL,
      name VARCHAR(255) NOT NULL,
      constituency_id int(5) NOT NULL, 
      region_id int(5) NOT NULL,
      updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);
  
  
  
  $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "voters (
      id int(10)  NOT NULL,
      firstname VARCHAR(255) NOT NULL,
      middlename VARCHAR(255) NOT NULL,
      lastname VARCHAR(255) NOT NULL,
      datebirth  VARCHAR(12),
      gender     ENUM('Male', 'Female'),
      residentialaddress VARCHAR(255),
      pollingstation_id   int(10) NOT NULL,
      residentialconstituency_id  int(10) NOT NULL,
      votingconstituency_id      int(10) NOT NULL,
      voterIDnumber              int(25) NOT NULL,
      lifestatus                VARCHAR(25),
      user_id         int(10),
      updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
      PRIMARY KEY (id)
  )";
  
  dbDelta($sql);
                                                             

}

// This function will create all required pages for this plugin
function create_pages() {

  global $wpdb, $current_user;
  
  $pages = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "plugin_pages");
  
  foreach ( $pages as $page ) 	{

    $new_page_title = $page->title;
    $new_page_content = $page->contents;
    $new_page_template = $page->template; //ex. template-custom.php. 
    
    $page_check = get_page_by_title($new_page_title);
    $new_page = array(
        'post_type' => 'page',
        'post_title' => $new_page_title,
        'post_content' => $new_page_content,
        'post_status' => 'publish',
        'post_author' => $current_user->ID,
    );
    
    if(!isset($page_check->ID)){
    
      $new_page_id = wp_insert_post($new_page);
      if(!empty($new_page_template)){
          update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
      }
      
    }
  }

}