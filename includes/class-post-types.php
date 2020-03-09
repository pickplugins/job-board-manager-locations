<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_locations_post_types{
	
	public function __construct(){
		
		add_action( 'init', array( $this, 'job_bm_locations_posttype_location' ), 0 );
		
		}
	
	public function job_bm_locations_posttype_location(){
		if ( post_type_exists( "location" ) )
		return;

		$singular  = __( 'Location', 'job-board-manager-locations' );
		$plural    = __( 'Locations', 'job-board-manager-locations' );
	 
	 
		register_post_type( "location",
			apply_filters( "register_post_type_location", array(
				'labels' => array(
					'name' 					=> $plural,
					'singular_name' 		=> $singular,
					'menu_name'             => $singular,
					'all_items'             => sprintf( __( 'All %s', 'job-board-manager-locations' ), $plural ),
					'add_new' 				=> __( 'Add New', 'job-board-manager-locations' ),
					'add_new_item' 			=> sprintf( __( 'Add %s', 'job-board-manager-locations' ), $singular ),
					'edit' 					=> __( 'Edit', 'job-board-manager-locations' ),
					'edit_item' 			=> sprintf( __( 'Edit %s', 'job-board-manager-locations' ), $singular ),
					'new_item' 				=> sprintf( __( 'New %s', 'job-board-manager-locations' ), $singular ),
					'view' 					=> sprintf( __( 'View %s', 'job-board-manager-locations' ), $singular ),
					'view_item' 			=> sprintf( __( 'View %s', 'job-board-manager-locations' ), $singular ),
					'search_items' 			=> sprintf( __( 'Search %s', 'job-board-manager-locations' ), $plural ),
					'not_found' 			=> sprintf( __( 'No %s found', 'job-board-manager-locations' ), $plural ),
					'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', 'job-board-manager-locations' ), $plural ),
					'parent' 				=> sprintf( __( 'Parent %s', 'job-board-manager-locations' ), $singular )
				),
				'description' => sprintf( __( 'This is where you can create and manage %s.', 'job-board-manager-locations' ), $plural ),
				'public' 				=> true,
				'show_ui' 				=> true,
				'capability_type' 		=> 'post',
				'map_meta_cap'          => true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> true,
				'query_var' 			=> true,
				'supports' 				=> array('title','editor','thumbnail','custom-fields'),
				'show_in_nav_menus' 	=> false,
				'show_in_menu' 	=> 'edit.php?post_type=job',				
				'menu_icon' => 'dashicons-admin-users',
			) )
		); 
	 
	 
		}
	
	
	}
	
	new class_job_bm_locations_post_types();