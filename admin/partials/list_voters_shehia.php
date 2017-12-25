<?php 

get_header();?>

<div class="container content_body">

<?php

if ( is_user_logged_in() ) {

/*
 *  This function takes shehia id, another function is called to retrieve polling station id 
 *  that is used to display voters in that polling station 
 */
function get_voters_shehia($id) {
  
     global $wpdb;
     
     $poll_id = get_polling_id($id);
     
     $voters = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "voters WHERE pollingstation_id = $poll_id ORDER BY gender, firstname, middlename, lastname ASC");
     ?>
     <h2 class="report-header">List of Voters in <?php echo get_shehia_name($id);?> Shehia</h2>
     <table class="table table-bordered">
       <tr>
          <th class="th">SN</th>
          <th class="th">Full Name</th>
          <th class="th">Date of Birth</th>
          <th class="th">Gender</th>
          <th class="th">Address</th>
          <th class="th">Polling Statio</th>
          <th class="th">Constituent</th>
          <th class="th">Voter ID</th>
          <th class="th">Life Status</th>
       </tr>
     <?php
     $i = 1;
     foreach ( $voters as $voter )	{?>
       <tr>
         <td><?php echo $i; ?></td> 
         <td><a href="<?php echo get_site_url(); ?>/list-of-voters-shehia/?voterID=<?=$voter->id?>"><?php echo $voter->firstname . " " . $voter->middlename . " " . $voter->lastname ;?></a></td>
         <td><?php echo $voter->datebirth; ?></td> 
          <td><?php echo $voter->gender; ?></td> 
         <td><?php echo $voter->residentialaddress; ?></td> 
         <td><?php echo get_polling_name($voter->pollingstation_id); ?></td> 
         <td><?php echo get_contituent_name($voter->residentialconstituency_id); ?></td> 
         <td><?php echo $voter->voterIDnumber; ?></td> 
         <td><?php echo $voter->lifestatus; ?></td> 
       </tr>
<?php $i++;
     } ?>
     </table>
<?php
} 


/*
 *  This function takes polling station id to display voters in that polling station
 */
function get_voters_polling_station($id) {
  
     global $wpdb;
     
     $voters = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "voters WHERE pollingstation_id = $id ORDER BY gender, firstname, middlename, lastname ASC");
     ?>
     <h2 class="report-header">List of Voters in <?php echo get_polling_name($id);?> Shehia</h2>
     <table class="table table-bordered">
       <tr>
          <th class="th">SN</th>
          <th class="th">Full Name</th>
          <th class="th">Date of Birth</th>
          <th class="th">Gender</th>
          <th class="th">Address</th>
          <!-- <th class="th">Polling Statio</th> -->
          <th class="th">Constituent</th>
          <th class="th">Voter ID</th>
          <th class="th">Life Status</th>
       </tr>
     <?php
     $i = 1;
     foreach ( $voters as $voter )	{?>
       <tr>
         <td><?php echo $i; ?></td> 
         <td><a href="<?php echo get_site_url(); ?>/list-of-voters-shehia/?voterID=<?=$voter->id?>"><?php echo $voter->firstname . " " . $voter->middlename . " " . $voter->lastname ;?></a></td>
         <td><?php echo $voter->datebirth; ?></td> 
          <td><?php echo $voter->gender; ?></td> 
         <td><?php echo $voter->residentialaddress; ?></td> 
         <!--<td><?php// echo get_polling_name($voter->pollingstation_id); ?></td>--> 
         <td><?php echo get_contituent_name($voter->residentialconstituency_id); ?></td> 
         <td><?php echo $voter->voterIDnumber; ?></td> 
         <td><?php echo $voter->lifestatus; ?></td> 
       </tr>
<?php $i++;
     } ?>
     </table>
<?php
}   

/*
 *  This function takes id parameter to display voter on editable form
 */ 
function display_voter($id) {
  global $wpdb;
  
  $shehia = $wpdb->get_row( $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "voters WHERE id = %d", $id), ARRAY_A);
?>
<div class="form">

<script>

$(document).ready(function () {

    $('#display_voter').validate({ // initialize the plugin
        rules: {
            firstname: {
                required: true
            },
            middlename: {
                required: true
            },
            lastname: {
                required: true
            },
            datebirth: {
                required: true
            }
        },
        messages: {
          firstname: "Please enter the first name",
          middlename: "Please enter the middle name",
          lastname: "Please enter the last name",
          datebirth: "Please enter the date of birth"
        }

    });

});
</script>

  <form class="form-horizonatal" method="post" id="display_voter" action="/list-of-voters-in-constituent/" enctype="multipart/form-data">
    <input type="hidden" name="update" value="1">
    <div class="form-group row">
      <label for="firstname" class="col-sm-3">First Name: </label>
      <div class="col-sm-7">
          <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $shehia['firstname']?>" required>
      </div>
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="middlename" class="col-sm-3">Middle Name: </label>
      <div class="col-sm-7">
          <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo $shehia['middlename']?>" required>
      </div>
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="lastname" class="col-sm-3">Last Name: </label>
      <div class="col-sm-7">
          <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $shehia['lastname']?>" required>
      </div>
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="datebirth" class="col-sm-3">Date of Birth: </label>
      <div class="col-sm-7">
          <input type="text" class="form-control" id="datebirth" name="datebirth" value="<?php echo $shehia['datebirth']?>" required>
      </div>
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="gender" class="col-sm-3">Gender </label>
      <div class="col-sm-7">
        <select class="form-control" id="gender" name="gender" required>
          <option value="<?=$shehia['gender']?>" selected><?=$shehia['gender']?></option>
          <option value="Female">Female</option>
          <option value="Male">Male</option>  
        </select>
      </div>
      <div class="col-sm-2"></div>
    </div>
         
    <div class="form-group row">
      <label for="residentialaddress" class="col-sm-3">Address: </label>
      <div class="col-sm-7">
          <input type="text" class="form-control" id="residentialaddress" name="residentialaddress" value="<?php echo $shehia['residentialaddress']?>" />
      </div>                                                                 
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="Sell_uom" class="col-sm-3">Polling Station: </label>
      <div class="col-sm-7">
          <select class="form-control" id="pollingstation_id" name="pollingstation_id" required>
            <option value=""></option>
            <option value="<?=$shehia['pollingstation_id']?>" selected><?php echo get_polling_name($shehia['pollingstation_id']);?></option>
            <?php get_list_polling_station($shehia['residentialconstituency_id']) ?> 
          </select>
      </div>
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="Sell_uom" class="col-sm-3">Residential Constituent: </label>
      <div class="col-sm-7">
          <select class="form-control" id="residentialconstituency_id" name="residentialconstituency_id" required>
            <option value="<?=$shehia['residentialconstituency_id']?>" selected><?=get_constituent_name($shehia['residentialconstituency_id'])?></option>
            <?php get_list_constituents(); ?>
          </select>
      </div>
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="Sell_uom" class="col-sm-3">Voting Constituent: </label>
      <div class="col-sm-7">
          <select class="form-control" id="votingconstituency_id" name="votingconstituency_id" required>
            <option value="<?=$shehia['votingconstituency_id']?>" selected><?=get_constituent_name($shehia['votingconstituency_id'])?></option>
             <?php get_list_constituents(); ?>
          </select>
      </div>
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="voterIDnumber" class="col-sm-3">Voter ID: </label>
      <div class="col-sm-7">
          <input type="number" class="form-control" id="voterIDnumber" name="voterIDnumber" value="<?php echo $shehia['voterIDnumber']?>" required >
      </div>
      <div class="col-sm-2"></div>
    </div>

    <div class="form-group row">
      <label for="lifestatus" class="col-sm-3">Life Status </label>
      <div class="col-sm-7">
        <select class="form-control" id="lifestatus" name="lifestatus" required>
          <option value="<?=$shehia['lifestatus']?>" selected><?=$shehia['lifestatus']?></option>
          <option value="Is Live">Is Live</option>
          <option value="Dead">Dead</option>  
        </select>
      </div>
      <div class="col-sm-2"></div>
    </div>    
    
    <div class="form-group row">
      <label for="voterIDnumber" class="col-sm-3">Voter Image: </label>
      <div class="col-sm-7">
          <input type="file" class="form-control" id="voterImage" name="voterImage">
      </div>
      <div class="col-sm-2"></div>
    </div>
    
    <div class="form-group row">
      <label for="submit" class="col-sm-3"></label>
      <div class="col-sm-7">
          <button type="submit" name="update_voter" class="btn btn-primary">Update Voter</button>
      </div>
      <div class="col-sm-2"></div>
    </div>

  </form>
  
</div>

<?php
}

/*
 *  Contents of the page starts here
 */
  
  global $wpdb, $current_user;
  
  // Retrieving user meta from usermeta table
  $metas = get_user_meta($current_user->ID);
  
  if(isset($_GET['id'])) {
  
      get_voters_shehia($_GET['id']);
      
  } else if(isset($_GET['pollingID'])) {
  
      get_voters_polling_station($_GET['pollingID']);
      
  } else if(isset($_GET['voterID'])) {
  
      display_voter($_GET['voterID']); 
      
  } else if(isset($_POST['update_voter']) && $_POST['update'] == 1) {
  
     echo "We wil be able to update";
      
  } else {
  
      $shehia_id = $metas['shehia_id'][0];
      
      echo "Shehia ID " . $shehia_id;
  
  }


delete_pages_postmeta();

  
}

?>

</div>
<?php get_footer(); ?>