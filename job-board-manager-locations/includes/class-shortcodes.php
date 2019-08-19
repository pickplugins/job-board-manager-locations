<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_locations_shortcodes{
	
    public function __construct(){
		
		add_shortcode( 'job_count_by_location', array( $this, 'job_bm_job_count_by_location_display' ) );
		add_shortcode( 'location_submit_form', array( $this, 'location_submit_form_display' ) );
		add_shortcode( 'jobs_in_map', array( $this, 'jobs_in_map_display' ) );
		add_shortcode( 'expandable_joblist', array( $this, 'expandable_joblist_display' ) );

   	}
		
		

	public function job_bm_job_count_by_location_display($atts, $content = null ) {
			$atts = shortcode_atts(
				array(
					'themes' => 'flat',
					'max_item' => 20,					
					
					), $atts);
	
			$html = '';
			$themes = $atts['themes'];
			$max_item = $atts['max_item'];			
			
			
			//$job_bm_locations_themes = get_post_meta( $post_id, 'job_bm_locations_themes', true );
			//$job_bm_locations_license_key = get_option('job_bm_locations_license_key');
			
/*
			if(empty($job_bm_locations_license_key))
				{
					return '<b>"'.job_bm_locations_plugin_name.'" Error:</b> Please activate your license.';
				}

*/
			
			//$class_job_bm_locations_functions = new class_job_bm_locations_functions();
			//$job_count_by_location_themes_dir = $class_job_bm_locations_functions->job_count_by_location_themes_dir();
			//$job_count_by_location_themes_url = $class_job_bm_locations_functions->job_count_by_location_themes_url();

			
			
			//echo '<link  type="text/css" media="all" rel="stylesheet"  href="'.$job_count_by_location_themes_url[$themes].'/style.css" >';				

			//include $job_count_by_location_themes_dir[$themes].'/index.php';				
			include job_bm_locations_plugin_dir .'templates/job-count-by-location.php';

			return $html;
	
		}
		
		public function jobs_in_map_display($atts, $content = null ) {
			$atts = shortcode_atts(
				array(
				), $atts);
	
			$html = '';
			
			//echo '<link  type="text/css" media="all" rel="stylesheet"  href="'.$job_count_by_location_themes_url[$themes].'/style.css" >';				

			include job_bm_locations_plugin_dir .'templates/jobs-in-map.php';				

			return $html;
		}
		
		public function expandable_joblist_display($atts, $content = null ) {
			$atts = shortcode_atts(
				array(
				), $atts);
	
			$html = '';
			
			include job_bm_locations_plugin_dir .'templates/expandable-joblist.php';
            wp_enqueue_style( 'font-awesome-5' );

			return $html;
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
            wp_enqueue_style('common');
			
			// return $html;
		}
			
	}
	
	new class_job_bm_locations_shortcodes();