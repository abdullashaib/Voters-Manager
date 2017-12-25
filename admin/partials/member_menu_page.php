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
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="" class="btn btn-primary">Polling Station <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><a href="#">Add Polling</a></li>
          <li><a href="#">Edit Polling</a></li>
          <li><a href="<?php echo get_site_url(); ?>/list-of-polling-stations/">List Polling</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="" class="btn btn-primary">Shehia <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="" class="btn btn-primary">Word <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="" class="btn btn-primary">Constituent <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="" class="btn btn-primary">Voters <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
      </ul>
    </li>
  </ul>
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