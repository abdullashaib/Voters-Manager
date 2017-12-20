<?php

/**
Template Name: Member Menu Page
Description: This is the member menu page that will display menus based on member role.

*/

get_header(); ?>

<div class="container content_body">

<?php

if ( is_user_logged_in() ) { ?>
<div class="navbar">

  <a href="" class="btn btn-primary">Polling Station </a>
  <a href="" class="btn btn-primary">Shehia </a>
  <a href="" class="btn btn-primary">Word </a>
  <a href="" class="btn btn-primary">Constituent </a>
  <a href="" class="btn btn-primary">Voters </a>

</div>

<?php

  global $wpdb, $current_user;
  
  $role = getRole();
  
  $metas = get_user_meta($current_user->ID);
  
  echo $metas['role_id'][0] . "<br />";
  
  echo $metas['polling_id'][0] . "<br />";
  
  echo $metas['shehia_id'][0] . "<br />";
  
  echo $metas['word_id'][0] . "<br />";
  
  echo $metas['constituent_id'][0] . "<br />";
  
  echo "<h1> Testing Page</h1>";

}

?>

</div>

<?php get_footer(); ?>