<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_job_bm_locations_frontend_form{
	
	public function __construct(){
		
		
	}
	
	public function frontend_forms_html($form_info,$meta_options){
			$html = '';
			
			$job_bm_reCAPTCHA_enable 			= get_option('job_bm_reCAPTCHA_enable');		
			$job_bm_reCAPTCHA_site_key 			= get_option('job_bm_reCAPTCHA_site_key');
			$job_bm_reCAPTCHA_secret_key 		= get_option('job_bm_reCAPTCHA_secret_key');
			$job_bm_submitted_location_status 	= get_option('job_bm_submitted_location_status');				
			$job_bm_location_login_page_id		= get_option('job_bm_location_login_page_id');
			
			if( empty($job_bm_submitted_location_status))	$job_bm_submitted_location_status = 'pending';
			if( empty($job_bm_location_login_page_id))	$job_bm_location_login_page_id = '';
			
			if( is_user_logged_in() )  $userid = get_current_user_id();
			else return '<div class="job_bm_front_error"><i class="fa fa-exclamation-triangle"></i> '.sprintf(__('Please <a href="%s">login</a> to continue!', 'job-board-manager-locations'), get_permalink($job_bm_location_login_page_id)).' </div>';
			
			$html.= '<div class="frontend-forms '.$form_info['form-id'].'">';
			$html.= '<div class="validations" ></div>';	
			
			if( isset($_GET['job_edit_id']) ) {
				$job_edit_id = (int)$_GET['job_edit_id'];
				$job_data = get_post($job_edit_id);

				$post_title = $job_data->post_title;
				$post_content = $job_data->post_content;
			}
			else {
				$post_title ='';
				$post_content ='';
			}
				
			if( empty($_POST['frontend_form_hidden']) ) {}
			elseif(isset($_POST['frontend_form_hidden']) && $_POST['frontend_form_hidden'] == 'Y' && !empty($_POST['g-recaptcha-response']))
			{
				$post_title = sanitize_text_field($_POST['post_title']);
				$post_content = sanitize_text_field($_POST['post_content']);				

				$job_post = array(
					'post_title'    => $post_title,
					'post_content'	=> $post_content,
					'post_status'   => $job_bm_submitted_location_status,
					'post_type'   	=> $form_info['post-type'],
					'post_author'   => $userid,
				);
				$new_post_ID = wp_insert_post($job_post);
					
				foreach($meta_options as $key=>$options){
					
					foreach($options as $option_key=>$option_info){
						
						if(!empty($_POST[$option_key])){
							
							$option_value = $_POST[$option_key];
							$option_value = job_bm_sanitize_data($option_info['input_type'],$_POST[$option_key]);
						}
						else $option_value = '';
						
						update_post_meta($new_post_ID, $option_key , $option_value);
					}
				}
				$html.= '<div class="message green" ><i class="fa fa-check-square-o"></i> '.__( sprintf('%s Submited',ucfirst($form_info['post-type'])), 'job-board-manager-locations').'</div>';
				$html.= '<div class="submission-status" ><i class="fa fa-exclamation-triangle"></i> '.__('Submission Status:','job-board-manager-locations').' '.$job_bm_submitted_location_status.'</div>';
			
				//header('Location: '. $_SERVER['REQUEST_URI'] );
			
			}
			else
			{
				$html.= '<div class="message warring" ><i class="fa fa-close"></i> '.__('Something error','job-board-manager-locations').'</div>';
			}
			global $post;
			

			$html.= '<form id="frontend-form-'.$form_info['post-type'].'-submit" enctype="multipart/form-data"   method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">';
			$html.= '<input type="hidden" name="frontend_form_hidden" value="Y">';	
			
			if ( !empty($form_info['post_title']) )
			{
				$html.= '<div class="option-box" >';	
				$html.= '<p class="option-title">'.$form_info['post_title'].'</p>';	
				$html.= '<p class="option-info"></p>';
				$html.= '<input type="text" class="post_title" name="post_title" value="'.sanitize_text_field($post_title).'" />';
				$html.= '</div>';
			}
			if ( !empty($form_info['post_content']) ) 
			{
				$html.= '<div class="option-box" >';
				$html.= '<p class="option-title">'.$form_info['post_content'].'</p>';
				$html.= '<p class="option-info"></p>';
				
				ob_start();
				wp_editor( stripslashes($post_content), 'post_content', $settings = array('textarea_name'=>'post_content','media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'150px', ) );				
				$editor_contents = ob_get_clean();
				$html.= $editor_contents;
				$html.= '</div>';
			}
			
			$html_nav = '';
			$html_box = '';
					
			$i=1;
			foreach($meta_options as $key=>$options)
			{
				if($i==1) $html_nav.= '<li nav="'.$i.'" class="nav'.$i.' active">'.$key.'</li>';				
				else $html_nav.= '<li nav="'.$i.'" class="nav'.$i.'">'.$key.'</li>';
				
				if($i==1) $html_box.= '<li style="display: block;" class="box'.$i.' tab-box active">';				
				else $html_box.= '<li style="display: none;" class="box'.$i.' tab-box">';
				
				foreach($options as $option_key=>$option_info)
				{
					if(isset($_GET['job_edit_id']))
						$option_value =  get_post_meta( (int)$_GET['job_edit_id'], $option_key, true );
					else
						$option_value =  get_post_meta( $post->ID, $option_key, true );
									
					if(empty($option_value)) $option_value = $option_info['input_values'];
				
					$html_box.= '<div class="option-box '.$option_info['css_class'].'">';
					$html_box.= '<p class="option-title">'.$option_info['title'].'</p>';
					$html_box.= '<p class="option-info">'.$option_info['option_details'].'</p>';
					
					if($option_info['input_type'] == 'text')
						$html_box.= '<input id="'.$option_key.'" type="text" placeholder="" name="'.$option_key.'" value="'.$option_value.'" /> ';					
					elseif($option_info['input_type'] == 'textarea')
						$html_box.= '<textarea placeholder="" id="'.$option_key.'" name="'.$option_key.'" >'.$option_value.'</textarea> ';
					elseif($option_info['input_type'] == 'wp_editor')
					{
						ob_start();
						wp_editor( stripslashes($option_value), $option_key, $settings = array('textarea_name'=>$option_key,'media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'150px', ) );				
						$editor_contents = ob_get_clean();
						$html_box.= $editor_contents;
					}
					elseif($option_info['input_type'] == 'radio')
					{
						$input_args = $option_info['input_args'];
						foreach($input_args as $input_args_key=>$input_args_values)
						{
							if($input_args_key == $option_value) $checked = 'checked';
							else $checked = '';
							
							$html_box.= '<label><input class="'.$option_key.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'"   >'.$input_args_values.'</label><br/>';
						}
					}
					elseif($option_info['input_type'] == 'select')
					{
						$input_args = $option_info['input_args'];
						$html_box.= '<select name="'.$option_key.'" >';
						foreach($input_args as $input_args_key=>$input_args_values)
						{
							if($input_args_key == $option_value) $selected = 'selected';
							else $selected = '';
							$html_box.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';
						}
						$html_box.= '</select>';
					}					
					elseif($option_info['input_type'] == 'checkbox')
					{
						$input_args = $option_info['input_args'];
						foreach($input_args as $input_args_key=>$input_args_values)
						{
							if ( !empty($option_value) )
								if(in_array($input_args_key,$option_value))
									$checked = 'checked';
								else $checked = '';
								
							$html_box.= '<label><input class="'.$option_key.'" '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'[]"  type="checkbox" >'.$input_args_values.'</label><br/>';
						}
					}
					elseif($option_info['input_type'] == 'file')
					{
						$html_box.= '<input  type="text" id="file_'.$option_key.'" name="'.$option_key.'" value="'.$option_value.'" /><br />';
						$html_box .= '<div id="file-upload-container">';
						$html_box .= '<a title="filetype: (jpg, png, jpeg), max size: 200Mb" id="file-uploader" class="sticker_button" href="#">'.__('Upload', 'job-board-manager-locations').'</a>
						<div id="uploaded-image-container"></div></div>';
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
					
			if($job_bm_reCAPTCHA_enable=='yes')
			{
				$html.= '<div class="option-box" >';	
				$html.= '<p class="option-title" >reCAPTCHA</p>';	
				$html.= '<p class="option-info"></p>';
				$html.= '<script src="https://www.google.com/recaptcha/api.js"></script>';	
				$html.= '<div class="g-recaptcha" data-sitekey="'.$job_bm_reCAPTCHA_site_key.'"></div>';	
				$html.= '</div>';
			}
			else $html.= '<input type="hidden" name="g-recaptcha-response" value="yes" />';
				
			$html.= '<input class="button job-bm-submit" type="submit" value="'.__('Submit','job-board-manager-locations' ).'" />';
			$html.= '</form>';
			$html.= '</div>';

			return $html;
			
			
		}
	
	}