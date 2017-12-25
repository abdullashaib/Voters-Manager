<?php 

get_header();?>

<div class="container content_body">

<?php

if ( is_user_logged_in() ) {

  global $wpdb;
  
  $consts = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "constituency ORDER BY id ASC");
  
  foreach($consts as $const) {
     echo "<h2>" . $const->constituency . "</h2>";
     
     $words = $wpdb->get_results("SELECT DISTINCT word_id FROM " . $wpdb->prefix . "shehia WHERE constituency_id = " . $const->id . " ORDER BY name ASC");
     ?>
     <table class="table table-bordered">
       <tr>
          <th class="th">Word Name</th>
        </tr>
     <?php
       foreach($words as $word) {?>
        <tr>
          <td><?php echo $word->word_id ;?> </td>
        </tr>
       <?php
       }
     ?>  
     </table> 
     <?php
  }


}

?>

</div>
<?php get_footer(); ?>