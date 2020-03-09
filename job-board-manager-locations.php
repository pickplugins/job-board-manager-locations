<?php
/*
Plugin Name: Job Board Manager - Locations
Plugin URI: http://pickplugins.com
Description: Awesome location single page and display job list under any location via single page.
Version: 1.0.10
Author: pickplugins
Text Domain: job-board-manager-locations
Domain Path: /languages
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class JobBoardManagerLocations{
	
	public function __construct(){
	
        define('job_bm_locations_plugin_url', plugins_url('/', __FILE__)  );
        define('job_bm_locations_plugin_dir', plugin_dir_path( __FILE__ ) );
        define('job_bm_locations_wp_url', 'https://wordpress.org/plugins/job-board-manager-locations/' );
        define('job_bm_locations_plugin_name', 'Job Board Manager - Locations' );
        define('job_bm_locations_plugin_version', '1.0.10' );


        // Class
        require_once( job_bm_locations_plugin_dir . 'includes/class-post-types.php');
        //require_once( job_bm_locations_plugin_dir . 'includes/class-post-meta.php');

        require_once( job_bm_locations_plugin_dir . 'includes/class-post-meta-location.php');
        require_once( job_bm_locations_plugin_dir . 'includes/class-post-meta-location-hook.php');


        require_once( job_bm_locations_plugin_dir . 'includes/class-shortcodes.php');
        require_once( job_bm_locations_plugin_dir . 'includes/class-functions.php');
        require_once( job_bm_locations_plugin_dir . 'includes/class-settings.php');
        require_once( job_bm_locations_plugin_dir . 'includes/class-locations-frontend-form.php');

        require_once( job_bm_locations_plugin_dir . 'includes/functions-settings.php');



        require_once( job_bm_locations_plugin_dir . 'templates/location-single/location-single-hook.php');



        // Function's
        require_once( job_bm_locations_plugin_dir . 'includes/functions-dashboard.php');

        require_once( job_bm_locations_plugin_dir . 'includes/functions.php');
        //require_once( job_bm_locations_plugin_dir . 'templates/location-single-template-functions.php');

        add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
        add_action( 'wp_enqueue_scripts', array( $this, 'job_bm_locations_front_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'job_bm_locations_admin_scripts' ) );
	
        add_action( 'init', array( $this, 'load_textdomain' ));


	}
		
		
	public function load_textdomain() {

        $locale = apply_filters( 'plugin_locale', get_locale(), 'job-board-manager-locations' );
        load_textdomain('job-board-manager-locations', WP_LANG_DIR .'/job-board-manager-locations/job-board-manager-locations-'. $locale .'.mo' );

        load_plugin_textdomain( 'job-board-manager-locations', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}
		
		
		
	public function job_bm_locations_front_scripts(){
		
		wp_enqueue_script('jquery');

		wp_register_script( 'maps.google.js', 'https://maps.googleapis.com/maps/api/js');
		//wp_enqueue_script('job_bm_locations_js', plugins_url( '/assets/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		//wp_localize_script( 'job_bm_locations_js', 'job_bm_locations_ajax', array( 'job_bm_locations_ajaxurl' => admin_url( 'admin-ajax.php')));

		//wp_enqueue_style('job_bm_locations_style', job_bm_locations_plugin_url.'assets/front/css/style.css');

        wp_register_style('job_bm_location_single', job_bm_locations_plugin_url.'assets/front/css/location-single.css');
        wp_register_style('job_bm_my_locations', job_bm_locations_plugin_url.'assets/front/css/my-locations.css');



		
		}

	public function job_bm_locations_admin_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		//wp_enqueue_script('jquery-ui-autocomplete');

		wp_enqueue_script('job_bm_locations_admin_js', plugins_url( '/assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'job_bm_locations_admin_js', 'job_bm_locations_ajax', array( 'job_bm_locations_ajaxurl' => admin_url( 'admin-ajax.php')));
		wp_enqueue_style('job_bm_locations_admin_style', job_bm_locations_plugin_url.'assets/admin/css/style.css');


		}
	
	
	
	
	}

new JobBoardManagerLocations();