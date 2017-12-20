<?php 

get_header();?>

<div class="container content_body">

<?php

if ( is_user_logged_in() ) {

  global $wpdb, $current_user;
  
  // Retrieving user meta from usermeta table
  $metas = get_user_meta($current_user->ID);
  
  if(isset($_GET['id'])) {
  
      get_polling_stations($_GET['id']);
      
  } else if(isset($_POST['update_voter']) && $_POST['update'] == 1) {
     echo "We wil be able to update";
  }
  
  //echo "Voters in Constituent";

}
?>
</div>
<?php get_footer(); ?>