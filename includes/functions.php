<?php
if ( ! defined('ABSPATH')) exit;  // if direct access
	



function job_bm_locations_ajax_job_location_list(){
	$name = $_POST['name'];
	$company_name = '';
	 
	global $wpdb;
	
	$company_ids = $wpdb->get_col("select ID from $wpdb->posts where post_title like '%".$name."%' ");
	if(!empty($company_ids)){
		
		$args = array(	'post_type' => 'location',
						'post_status' => 'publish',
						'post__in' => $company_ids,
						'orderby' => 'title',
						'order' => 'ASC',
						'posts_per_page' => 10,);
						
		$company_data = get_posts($args);		
			
			
		if(!empty($company_data)){
			
			foreach($company_data as $key=>$values){
				
				$company_name.= '<div location-data="'.$values->post_title.'" class="item">'.$values->post_title.'</div>';
				
				}
			}
		else{
			
			$company_name.= '<div class="item">'.__('Nothing found', 'job-board-manager-locations').'</div>';
			}
						
		}
	else{
		
		$company_name.= '<div class="item">'.__('Nothing found', 'job-board-manager-locations').'</div>';
		} 

	echo $company_name;

	
	die();
	}
add_action('wp_ajax_job_bm_locations_ajax_job_location_list', 'job_bm_locations_ajax_job_location_list');
add_action('wp_ajax_nopriv_job_bm_locations_ajax_job_location_list', 'job_bm_locations_ajax_job_location_list');





	function curl_get_contents($url){
	  $curl = curl_init($url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	  $data = curl_exec($curl);
	  curl_close($curl);
	  return $data;
	}
	
	
	
	
	

	
	
	
	
	
	
	
	