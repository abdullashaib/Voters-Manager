<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.abdullashaib.com
 * @since      1.0.0
 *
 * @package    Wp_voters_manager
 * @subpackage Wp_voters_manager/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_voters_manager
 * @subpackage Wp_voters_manager/includes
 * @author     Abdulla Shaib <ashaib5@yahoo.com>
 */
class Wp_voters_manager_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	
	   require_once plugin_dir_path( __FILE__ ) . 'plugin_table_creation.php';
	   
	   /*
	    * This function call is for creating database tables
	    */	    
	   create_db_tables();
	   
	   /*
	    *  This function call is for creating pages and updating postmeta for custom template
	    */
	   create_pages();
	   
	   
	   

	}

}
