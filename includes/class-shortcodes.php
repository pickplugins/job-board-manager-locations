<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_locations_shortcodes{
	
    public function __construct(){
		
		add_shortcode( 'job_bm_location_submit_form', array( $this, 'location_submit_form_display' ) );
        add_shortcode( 'job_bm_my_locations', array( $this, 'job_bm_my_locations_display' ) );

   	}

    public function location_submit_form_display($atts, $content = null ) {

        include( job_bm_locations_plugin_dir . 'templates/location-submit/location-submit-hook.php');


        ob_start();
        include( job_bm_locations_plugin_dir . 'templates/location-submit/location-submit.php');

        wp_enqueue_style('job-bm-job-submit');

        wp_enqueue_script('job-bm-media-upload');
        wp_enqueue_style('job-bm-media-upload');
        // For media uploader in front-end
        wp_enqueue_media();
        //wp_enqueue_style('common');

        return ob_get_clean();
        // return $html;
    }

    public function job_bm_my_locations_display($atts, $content = null ) {

        include( job_bm_locations_plugin_dir . 'templates/my-locations/my-locations-hook.php');


        ob_start();
        include( job_bm_locations_plugin_dir . 'templates/my-locations/my-locations.php');

        wp_enqueue_style('job_bm_my_locations');


        return ob_get_clean();
        // return $html;
    }




	}
	
	new class_job_bm_locations_shortcodes();