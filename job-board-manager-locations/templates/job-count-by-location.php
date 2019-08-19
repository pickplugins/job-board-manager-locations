<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	$query_args= array('post_type'=>'location',  'post_status' => 'publish');
	
	$wp_query= new WP_Query($query_args);
	
	$html .= '<div class="job-count-by-location">';		
	
	if ( $wp_query->have_posts() ) :
	while ( $wp_query->have_posts() ) : $wp_query->the_post();	
	
	$job_query_args= array('post_type'=>'location',  'post_status' => 'publish');
	
	//$job_wp_query= new WP_Query($job_query_args);
 	$job_query = new WP_Query( array( 'post_type'=>'job','meta_key' => 'job_bm_location', 'meta_value' => get_the_title() ) );
	
	
	$job_count_by_location_data[get_the_ID()] = array('name'=>get_the_title(),'count'=>$job_query->found_posts,'url'=>get_the_permalink());

	endwhile;

	wp_reset_query();
	endif;	
	
	//var_dump($job_count_by_location_data);
	
	
	$job_query = new WP_Query( array( 'post_type'=>'job', 'post_status' => 'publish' ) );
	
	
	
	asort($job_count_by_location_data);
	$html.='<div class="total">'.__('Total Job Count','job-board-manager-locations').' - '.$job_query->found_posts.'</div>';
	
	
	//var_dump($job_count_by_location_data);
	
	
	$i=1;
	foreach($job_count_by_location_data as $location_key=>$location_data){
		
		if($i<=$max_item){
				
				if($location_data['count']>0)				
				$html.='<div class="single-location"><a href="'.$location_data['url'].'">'.$location_data['name'].'</a> - '.$location_data['count'].'</div>';
			}

		$i++;
		}

	
	
	$html .= '</div>'; // .job-count-by-location	

