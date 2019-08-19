<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_job_bm_locations_post_meta{
	
	public function __construct(){

		add_action('add_meta_boxes', array($this, 'meta_boxes_location'));
		add_action('save_post', array($this, 'meta_boxes_location_save'));

	}
	
	public function location_meta_options($options = array()){



	$class_job_bm_locations_functions = new class_job_bm_locations_functions();
	$job_bm_locations_country_list = $class_job_bm_locations_functions->job_bm_locations_country_list();





			$options['Location Info'] = array(
		
								'job_bm_location_country_code'=>array(
									'css_class'=>'country',					
									'title'=>__('Country', 'job-board-manager-locations'),
									'option_details'=>__('Country, ex: Bangladesh', 'job-board-manager-locations'),
									'input_type'=>'select', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									'input_args'=> $job_bm_locations_country_list,
									),
									
								'job_bm_location_latlang'=>array(
									'css_class'=>'latlang',					
									'title'=>__('Latitude, Longitude', 'job-board-manager-locations'),
									'option_details'=>__('Latitude,Longitude, ex: 46.414382,10.013988', 'job-board-manager-locations'),
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=>'', // could be array
									),									
									
															

						);




			
			$options = apply_filters( 'job_bm_locations_filters_meta_options', $options );

			return $options;
		
		}
	
	
	public function location_meta_options_form(){
		
			global $post;
			
			$location_meta_options = $this->location_meta_options();
			//var_dump($job_meta_options);
			$html = '';
			
			$html.= '<div class="para-settings job-bm-cp-settings">';			

			$html_nav = '';
			$html_box = '';
					
			$i=1;
			foreach($location_meta_options as $key=>$options){
			if($i==1){
				$html_nav.= '<li nav="'.$i.'" class="nav'.$i.' active">'.$key.'</li>';				
				}
			else{
				$html_nav.= '<li nav="'.$i.'" class="nav'.$i.'">'.$key.'</li>';
				}
				
				
			if($i==1){
				$html_box.= '<li style="display: block;" class="box'.$i.' tab-box active">';				
				}
			else{
				$html_box.= '<li style="display: none;" class="box'.$i.' tab-box">';
				}

				
			foreach($options as $option_key=>$option_info){

				$option_value =  get_post_meta( $post->ID, $option_key, true );
				//var_dump($option_value);
				
				
				if(empty($option_value)){
					$option_value = $option_info['input_values'];
					}
				
				
				$html_box.= '<div class="option-box '.$option_info['css_class'].'">';
				$html_box.= '<p class="option-title">'.$option_info['title'].'</p>';
				$html_box.= '<p class="option-info">'.$option_info['option_details'].'</p>';
				
				if($option_info['input_type'] == 'text'){
				$html_box.= '<input type="text" placeholder="" name="'.$option_key.'" value="'.$option_value.'" /> ';					

					}
				elseif($option_info['input_type'] == 'textarea'){
					$html_box.= '<textarea placeholder="" name="'.$option_key.'" >'.$option_value.'</textarea> ';
					
					}
					
					
					
					
				elseif($option_info['input_type'] == 'radio'){
					
					$input_args = $option_info['input_args'];
					
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $option_value){
							$checked = 'checked';
							}
						else{
							$checked = '';
							}
							
						$html_box.= '<label><input class="'.$option_key.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'"   >'.$input_args_values.'</label><br/>';
						}
					
					
					}
					
					
				elseif($option_info['input_type'] == 'select'){
					
					$input_args = $option_info['input_args'];
					$html_box.= '<select name="'.$option_key.'" >';
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if($input_args_key == $option_value){
							$selected = 'selected';
							}
						else{
							$selected = '';
							}
						
						$html_box.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';

						}
					$html_box.= '</select>';
					
					}					
					
					
					
					
					
					
					
					
				elseif($option_info['input_type'] == 'checkbox'){
					
					$input_args = $option_info['input_args'];
					
					foreach($input_args as $input_args_key=>$input_args_values){
						
						
						if(empty($option_value[$input_args_key])){
							$checked = '';
							}
						else{
							$checked = 'checked';
							}
						$html_box.= '<label><input '.$checked.' value="'.$input_args_values.'" name="'.$option_key.'['.$input_args_key.']"  type="checkbox" >'.$input_args_values.'</label><br/>';
						
						
						}
					
					
					}
					
				elseif($option_info['input_type'] == 'file'){
					
					$html_box.= '<input type="text" id="file_'.$option_key.'" name="'.$option_key.'" value="'.$option_value.'" /><br />';
					
					$html_box.= '<input id="upload_button_'.$option_key.'" class="upload_button_'.$option_key.' button" type="button" value="'.__('Upload File','job-board-manager-locations').'" />';
					
					$html_box.= '<br /><br /><div style="overflow:hidden;max-height:150px;max-width:150px;" class="logo-preview"><img width="100%" src="'.$option_value.'" /></div>';
					
					$html_box.= '
<script>
								jQuery(document).ready(function($){
	
									var custom_uploader; 
								 
									jQuery("#upload_button_'.$option_key.'").click(function(e) {
	
										e.preventDefault();
								 
										//If the uploader object has already been created, reopen the dialog
										if (custom_uploader) {
											custom_uploader.open();
											return;
										}
								
										//Extend the wp.media object
										custom_uploader = wp.media.frames.file_frame = wp.media({
											title: "Choose File",
											button: {
												text: "Choose File"
											},
											multiple: false
										});
								
										//When a file is selected, grab the URL and set it as the text field\'s value
										custom_uploader.on("select", function() {
											attachment = custom_uploader.state().get("selection").first().toJSON();
											jQuery("#file_'.$option_key.'").val(attachment.url);
											jQuery(".logo-preview img").attr("src",attachment.url);											
										});
								 
										//Open the uploader dialog
										custom_uploader.open();
								 
									});
									
									
								})
							</script>
					
					';					
					
					
					
					
					}		
					
					
										
					
								
				$html_box.= '</div>';
				
				}
			$html_box.= '</li>';
			
			
			$i++;
			}
			
			
			$html.= '<ul class="tab-nav">';
			$html.= $html_nav;			
			$html.= '</ul>';
			$html.= '<ul class="box">';
			$html.= $html_box;
			$html.= '</ul>';		
			
			
			
			$html.= '</div>';			
			return $html;
		}
	
	
	
	
	public function meta_boxes_location($post_type) {
			$post_types = array('location');
	 
			//limit meta box to certain post types
			if (in_array($post_type, $post_types)) {
				add_meta_box('location_metabox',
				__('Location Data', 'job-board-manager-locations'),
				array($this, 'location_meta_box_function'),
				$post_type,
				'normal',
				'high');
			}
		}
	public function location_meta_box_function($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('location_nonce_check', 'location_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.
       // $job_bm_locations_data = get_post_meta($post -> ID, 'job_bm_locations_data', true);

		$location_meta_options = $this->location_meta_options();
		
		//var_dump($job_meta_options);
		foreach($location_meta_options as $options_tab=>$options){
			
			foreach($options as $option_key=>$option_data){
				
				${$option_key} = get_post_meta($post -> ID, $option_key, true);

				}
			}
			
		//var_dump($job_bm_locations_salary_currency);
        // Display the form, using the current value.
		
		?>
        <div class="job-bm-cp-meta">
        
        <?php
		
		
        echo $this->location_meta_options_form(); 
		?>
        </div>
        <?php
		

		
		




   		}
	
	
	public function meta_boxes_location_save($post_id){
	 
			/*
			 * We need to verify this came from the our screen and with 
			 * proper authorization,
			 * because save_post can be triggered at other times.
			 */
	 
			// Check if our nonce is set.
			if (!isset($_POST['location_nonce_check_value']))
				return $post_id;
	 
			$nonce = $_POST['location_nonce_check_value'];
	 
			// Verify that the nonce is valid.
			if (!wp_verify_nonce($nonce, 'location_nonce_check'))
				return $post_id;
	 
			// If this is an autosave, our form has not been submitted,
			//     so we don't want to do anything.
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return $post_id;
	 
			// Check the user's permissions.
			if ('page' == $_POST['post_type']) {
	 
				if (!current_user_can('edit_page', $post_id))
					return $post_id;
	 
			} else {
	 
				if (!current_user_can('edit_post', $post_id))
					return $post_id;
			}
	 
			/* OK, its safe for us to save the data now. */
	 
			// Sanitize the user input.
			//$job_bm_locations_data = stripslashes_deep($_POST['job_bm_locations_data']);
	
			
			// Update the meta field.
			//update_post_meta($post_id, 'job_bm_locations_data', $job_bm_locations_data);
			
			$location_meta_options = $this->location_meta_options();
			
			foreach($location_meta_options as $options_tab=>$options){
				
				foreach($options as $option_key=>$option_data){
					
					${$option_key} = stripslashes_deep($_POST[$option_key]);
					
					update_post_meta($post_id, $option_key, ${$option_key});			
					
					}
				}
			
			
			
			
			
					
		}
	
	}


new class_job_bm_locations_post_meta();