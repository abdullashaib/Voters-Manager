<?php 

get_header();?>

<div class="container content_body">

<?php

if ( is_user_logged_in() ) {

/*
 * This function takes word id to return polling stations for that particular word
 */ 
function get_pollings_word($id) {

  global $wpdb;
     
  $words = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "pollingstation_shehia WHERE word_id = $id ORDER BY pollingstation_id ASC");
  
  foreach( $words as $word) { ?>
    <h2><a href="<?php echo get_site_url(); ?>/list-of-voters-shehia/?pollingID=<?=$word->pollingstation_id?>"><?php echo get_polling_name($word->pollingstation_id);?></a></h2>
  <?php
  }
    

}

//echo get_polling_ids(6);


/*
 *  Contents of the page starts here
 */
  
  global $wpdb, $current_user;
  
  $metas = get_user_meta($current_user->ID);
  
  $word_id = $metas['word_id'][0];
  
  get_pollings_word($word_id);
  
}


?>

</div>
<?php get_footer(); ?>