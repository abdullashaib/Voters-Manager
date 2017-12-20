<?php 

get_header();?>

<div class="container content_body">

<?php

if ( is_user_logged_in() ) {


  global $wpdb, $current_user;
  
  // Retrieving user meta from usermeta table
  $metas = get_user_meta($current_user->ID);
  
  /*
   * This function takes constituent id to retrieve shehia list for that constituent
   */   
  function get_shehia_constituent($id) {
  
     global $wpdb;
     
     $shehias = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "shehia WHERE constituency_id = $id ORDER BY name ASC");
     ?>
     <table class="table table-bordered">
       <tr>
          <th>SN</th>
          <th>Shehia Name</th>
       </tr>
     <?php
     $i = 1;
     foreach ( $shehias as $shehia )	{?>
       <tr>
         <td><?php echo $i; ?></td> 
         <td><a href="<?php echo get_site_url(); ?>/list-of-voters-shehia/?id=<?=$shehia->id?>"><?php echo $shehia->name;?></a></td>
       </tr>
<?php $i++;
     } ?>
     </table>
<?php
  }
  
  /*
   * Function that return all contituents
   */   
  function get_constituents() {

    global $wpdb;
    
    $consts = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "constituency ORDER BY constituency ASC");
    echo "<h1 class='report-header'> List of Constituents</h1>";
    echo "<div class='contituent'><ul>";
    $i = 1;
    foreach ( $consts as $const ) 	{ ?>          
       <li><?=$i . "\t "?><a href="<?php echo get_site_url(); ?>/list-of-voters-in-constituent/?id=<?=$const->id?>"><?php echo $const->constituency;?></a></li>
    <?php
    $i++;             
    }
    echo "</ul></div>";
  }
  
  if($metas['polling_id'][0]) {
      echo "<h1>Welcome <span style='color:navy'>" . $metas['role_id'][0] . "</span><br />You are agent</h1>"; 
  } else if($metas['shehia_id'][0]) {
      echo "<h1>You are sheha</h1>";
  } else if($metas['word_id'][0]) {
      echo "<h1>You are conceilor</h1>";
  } else if($metas['constituent_id'][0]) {
      echo "<h1>Welcome <span style='color:navy'>" . get_role_title($metas['role_id'][0]) . "</span><br /> You are either MP or HoR</h1>";
      echo "Constituen ID " . $metas['constituent_id'][0] . "<br />";
      get_shehia_constituent($metas['constituent_id'][0]);
  } else {
      //echo "<h1>You are admin</h1>";
      get_constituents();
  }
  
  
  
  
  
  
  
  function get_words_constituent($id) {
  
  
  }
}

?>
</div>
<?php get_footer(); ?>