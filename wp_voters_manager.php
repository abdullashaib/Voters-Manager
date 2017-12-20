<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.abdullashaib.com
 * @since             1.0.0
 * @package           Wp_voters_manager
 *
 * @wordpress-plugin
 * Plugin Name:       Voters Manager
 * Plugin URI:        http://www.abdullashaib.com/VotersManager
 * Description:       This plugin is a complete web application used to manage voters registration in Zanzibar. 
 * Version:           1.0.0
 * Author:            Abdulla Shaib
 * Author URI:        http://www.abdullashaib.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_voters_manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );
 

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp_voters_manager-activator.php
 */
function activate_wp_voters_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp_voters_manager-activator.php';
	Wp_voters_manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp_voters_manager-deactivator.php
 */
function deactivate_wp_voters_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp_voters_manager-deactivator.php';
	Wp_voters_manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_voters_manager' );
register_deactivation_hook( __FILE__, 'deactivate_wp_voters_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp_voters_manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_voters_manager() {

	$plugin = new Wp_voters_manager();
	$plugin->run();

}



add_action('admin_menu', 'add_plugin_admin_menu');


function add_plugin_admin_menu() {

  $plugin_data = get_plugin_data( __FILE__ );
  $plugin_name = $plugin_data['Name'];
  
  add_menu_page( 'Voters Admin Page', 'Voters Manager', 'manage_options', $plugin_name, 'display_plugin_setup_page' );
  
  add_submenu_page($plugin_name, 'Manage Users', 'Manage Users', 'manage_options', $plugin_name.'/manage_users', 'manage_users_page');
}


function display_plugin_setup_page() {
  include_once( 'admin/partials/plugin_admin_page.php' );
}

function manage_users_page() {
  include_once( 'admin/partials/plugin_users_page.php' );
}


// function that check the role of logged in user
function getRole() {

  $user_role = "";

  $user_id = get_current_user_id();
	
  $user = new WP_User( $user_id );
  if ( !empty( $user->roles ) && is_array( $user->roles ) )
		{
			foreach ( $user->roles as $role )
			$user_role = $role;
		}
		
		return $user_role;

}


// Filter page template
add_filter('page_template', 'catch_plugin_template');

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );


/* Page template filter callback
 * All pages are created from data that comes from the database
 * to make things easier to manage 
 */ 
 
function catch_plugin_template($template) {
  global $wpdb;
  $pages = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "plugin_pages");
  
  foreach ( $pages as $page ) {
    // file.php is the set template
    if( is_page_template($page->template) ) {
        // Update path(must be path of the file in the plugin not theme) 
        $template = plugin_dir_path( __FILE__ ) . "admin/partials/" . $page->template;
    }
  }
  // Return
  return $template;
}  

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'role_id', $_POST['role_id'] );
    update_user_meta( $user_id, 'polling_id', $_POST['polling_id'] );
    update_user_meta( $user_id, 'shehia_id', $_POST['shehia_id'] );
    update_user_meta( $user_id, 'word_id', $_POST['word_id'] );
    update_user_meta( $user_id, 'constituent_id', $_POST['constituent_id'] );
}

// Adding extra user fields needed for the plugin
function extra_user_profile_fields( $user ) { 

  global $wpdb, $current_user; 
  
  $constituents = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "constituency ORDER BY constituency ASC");
  $roles = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "roles");
  $pollings = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "pollingstations");
  $shehias = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "shehia");
  $words = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "words");

?>
  
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
    <tr>
        <th><label for="position"><?php _e("Position"); ?></label></th>
        <td>
            <select name="role_id" id="role_id">
              <option value=""></option>
            <?php
               foreach ( $roles as $role ) 	{
                 $id = $role->id;
                 $selected = get_the_author_meta( 'role_id', $user->ID );
                 if($id == $selected) {
                    echo "<option value='$id' selected>$role->name</option>";
                 } else {
                    echo "<option value='$id'>$role->name</option>";
                 }
               }
            ?>
            </select>
            <br />
            <span class="description"><?php _e("Please select position."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="polling_id"><?php _e("Polling Station"); ?></label></th>
        <td>
            <select name="polling_id" id="polling_id">
              <option value=""></option>
            <?php
               foreach ( $pollings as $polling ) 	{
                 $id = $polling->id;
                 $selected = get_the_author_meta( 'polling_id', $user->ID );
                 if($id == $selected) {
                    echo "<option value='$id' selected>$polling->name</option>";
                 } else {
                    echo "<option value='$id'>$polling->name</option>";
                 }
               }
            ?>
            </select>
            <br />
            <span class="description"><?php _e("Please select polling station."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="shehia_id"><?php _e("Shehia"); ?></label></th>
        <td>
            <select name="shehia_id" id="shehia_id">
              <option value=""></option>
            <?php
               foreach ( $shehias as $shehia ) 	{
                 $id = $shehia->id;
                 $selected = get_the_author_meta( 'shehia_id', $user->ID );
                 if($id == $selected) {
                    echo "<option value='$id' selected>$shehia->name</option>";
                 } else {
                    echo "<option value='$id'>$shehia->name</option>";
                 }
               }
            ?>
            </select>
            <br />
            <span class="description"><?php _e("Please select shehia."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="word_id"><?php _e("Word"); ?></label></th>
        <td>
            <select name="word_id" id="word_id">
              <option value=""></option>
            <?php
               foreach ( $words as $word ) 	{
                 $id = $word->id;
                 $selected = get_the_author_meta( 'word_id', $user->ID );
                 if($id == $selected) {
                    echo "<option value='$id' selected>$word->name</option>";
                 } else {
                    echo "<option value='$id'>$word->name</option>";
                 }
               }
            ?>
            </select>
            <br />
            <span class="description"><?php _e("Please select word."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="constituent_id"><?php _e("Constituency"); ?></label></th>
        <td>
            <select name="constituent_id" id="constituent_id">
              <option value=""></option>
            <?php
               foreach ( $constituents as $const ) 	{
                 $id = $const->id;
                 $selected = get_the_author_meta( 'constituent_id', $user->ID );
                 if($id == $selected) {
                    echo "<option value='$id' selected>$const->constituency</option>";
                 } else {
                    echo "<option value='$id'>$const->constituency</option>";
                 }
               }
            ?>
            </select>
            <br />
            <span class="description"><?php _e("Please select constituency."); ?></span>
        </td>
    </tr>

    </table>
<?php }

/*
 *   This function take id parameter to display title of the user logged in 
 */
  
function get_role_title($id) {

  global $wpdb;
  
  $role_title = $wpdb->get_row( $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "roles WHERE id = %d", $id), ARRAY_A);
  
  return ucwords($role_title['name']);

}

/*
 *  This function take shehia id parameter to return
 *  polling station id which is used to lookup 
 *  from the voters table 
 */
   
function get_polling_id($id) {

  global $wpdb;
  
  $poll = $wpdb->get_row( $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "pollingstations WHERE shehia_id = %d", $id), ARRAY_A);
  
  return $poll['id'];

}


function get_polling_ids($id) {

  global $wpdb;
  
  $poll = $wpdb->get_row( $wpdb->prepare("SELECT count(*) AS total FROM " . $wpdb->prefix . "pollingstations WHERE shehia_id = %d", $id), ARRAY_A);
  echo "TOTAl = " . $poll['total'] . "<br />"; 
  if($poll['total'] > 1) {
     echo $poll['total'];
  } else {
    get_polling_id($id);
  }

}


/*
 *  This function take polling station id to return poling station name
 */  

function get_polling_name($id) {

  global $wpdb;
  
  $poll = $wpdb->get_row( $wpdb->prepare("SELECT name FROM " . $wpdb->prefix . "pollingstations WHERE id = %d", $id), ARRAY_A);
  
  return $poll['name'];

}

/*
 *  This function takes shehia id to return shehia name
 */ 
function get_shehia_name($id) {

  global $wpdb;
  
  $shehia = $wpdb->get_row( $wpdb->prepare("SELECT name FROM " . $wpdb->prefix . "shehia WHERE id = %d", $id), ARRAY_A);
  
  return $shehia['name'];
}

/*
 *  This function takes constituent id to return constituent name
 */ 
function get_contituent_name($id) {

  global $wpdb;
  
  $const = $wpdb->get_row( $wpdb->prepare("SELECT constituency FROM " . $wpdb->prefix . "constituency WHERE id = %d", $id), ARRAY_A);
  
  return $const['constituency'];
}


/*
 *  This function takes constituent id to return polling stations on that constituent
 */ 
function get_polling_stations($id) {

  global $wpdb;
  
  $polls = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "pollingstations WHERE constituency_id = $id");
  
  foreach ( $polls as $poll ) { ?>         
     <h2><a href="<?php echo get_site_url(); ?>/list-of-voters-shehia/?pollingID=<?=$poll->id?>"><?php echo $poll->name?></option>
  <?php             
  }
  
}


/*
 *  This function takes constituent id to return a list of polling stations in that constituent
 */ 
function get_list_polling_station($id) {

  global $wpdb;
  
  $polls = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "pollingstations WHERE constituency_id = $id");
  
  foreach ( $polls as $poll ) 	{           
     echo "<option value='$poll->id'>$poll->name</option>";             
  }
  
}

/*
 *  This function return list of constituent for drop down menu
 */
function get_list_constituents() {

  global $wpdb;
  
  $consts = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "constituency ORDER BY constituency ASC");
  
  foreach ( $consts as $const ) 	{           
     echo "<option value='$const->id'>$const->constituency</option>";             
  }

}

/*
 *  This function take constituent id to return constituent name
 */  

function get_constituent_name($id) {

  global $wpdb;
  
  $const = $wpdb->get_row( $wpdb->prepare("SELECT constituency FROM " . $wpdb->prefix . "constituency WHERE id = %d", $id), ARRAY_A);
  
  return $const['constituency'];

}

/*
 *  This is the generic function for INSERT operations, takes table name and array of field
 */ 
function mysql_insert_data($table, $form_data) {

    global $wpdb;
    
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);
    
    $wpdb->query("INSERT INTO $table ( ".implode(",", $fields)." ) VALUES ( '".implode("','", $form_data)."' )");
		
    if($wpdb->last_error !== '') {
  
    $str   = $wpdb->print_error();
    $query = htmlspecialchars( $wpdb->last_query, ENT_QUOTES );

    print "<div id='error'>
            <p class='wpdberror'><strong>WordPress database error:</strong> [$str]<br />
           </div>";
  
    } else {
      print "<div class='alert alert-success'>
              <strong>Record added</strong>
             </div>";
    } 
     
}


run_wp_voters_manager();
