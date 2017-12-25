<?php 

get_header();?>

<div class="container content_body">

<?php

if ( is_user_logged_in() ) {

  global $wpdb;
  
  $consts = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "constituency ORDER BY id ASC");
  
  foreach($consts as $const) {
     echo "<h2>" . $const->constituency . "</h2>";
     
     $pollings = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "pollingstations WHERE constituency_id = " . $const->id . " ORDER BY name ASC");
     ?>
     <table class="table table-bordered">
      <tr>
        <th class="th">Polling Station</th>
      </tr>
     <?php
     foreach($pollings as $polling) {  ?>
      <tr>
          <td><?php echo $polling->name;?></td>
      </tr>
      <?php
     }                 
  }


}

?>

</div>
<?php get_footer(); ?>