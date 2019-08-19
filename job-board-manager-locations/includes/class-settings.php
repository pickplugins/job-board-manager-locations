<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_job_bm_locations_settings  {
	
	
    public function __construct(){

		//add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
		add_filter('job_bm_settings_options',array( $this, 'job_bm_locations_settings_options_extra'));
		
    }
	

	public function admin_menu() {
		
		add_submenu_page( 'edit.php?post_type=job', __( 'Settings', 'job-board-manager-locations' ), __( 'Settings', 'job-board-manager-locations' ), 'manage_options', 'job_bm_locations-settings', array( $this, 'settings_page' ) );
		
		do_action( 'job_bm_locations_action_admin_menus' );
		
	}
	
	public function settings_page(){
		
		include( 'menu/settings.php' );
		}
	

// ############### Filter for settings_options ###################

function job_bm_locations_settings_options_extra($options){
	
	$options['<i class="fa fa-map-marker" ></i> Locations'] = array(
								'job_bm_locations_map_type'=>array(
									'css_class'=>'map_type',					
									'title'=>__('Map Display', 'job-board-manager-locations'),
									'option_details'=>__('Map Type in single location page header', 'job-board-manager-locations'),
									'input_type'=>'select', // text, radio, checkbox, select, 
									'input_values'=> array('dynamic'=>'dynamic'), // could be array
									'input_args'=> array('static'=>__('Static', 'job-board-manager-locations'),'dynamic'=>__('Dynamic', 'job-board-manager-locations'),'none'=>__('None', 'job-board-manager-locations')),
									),
								
								'job_bm_locations_map_zoom'=>array(
									'css_class'=>'map_zoom',					
									'title'=>__('Map zoom level', 'job-board-manager-locations'),
									'option_details'=>__('Map zoom in single location page header, value (0-20)', 'job-board-manager-locations'),
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=> '12', // could be array
									),
									
								'job_bm_display_wiki_content'=>array(
									'css_class'=>'display_wiki_content',					
									'title'=>__('Display Content from Wikipedia ?','job-board-manager-locations'),
									'option_details'=>__('Location content on single page display from wikipidea when empty.', 'job-board-manager-locations'),
									'input_type'=>'select', // text, radio, checkbox, select, 
									'input_values'=> 'yes', // could be array
									'input_args'=> array('yes'=>__('Yes', 'job-board-manager-locations'),'no'=>__('No', 'job-board-manager-locations')), // could be array
									),									
									

									
								);
	return $options;
		
	}


	}


new class_job_bm_locations_settings();

