<?php

function create_pages() {

  global $wpdb, $current_user;
  
  $new_page_title = 'Member Menu';
  $new_page_content = 'This is the member menu page that will display menus based on member role';
  $new_page_template = 'member_menu_page.php'; //ex. template-custom.php. 
  
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

?>