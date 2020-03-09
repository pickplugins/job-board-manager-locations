<?php	


/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



class class_job_bm_locations_settings_page  {
	
	
    public function __construct(){

		//add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
    }
	
	
	public function job_bm_locations_settings_options($options = array()){


			$class_job_bm_locations_functions = new class_job_bm_locations_functions();
			
			$job_bm_locations_list_user_role = $class_job_bm_locations_functions->job_bm_locations_list_user_role();




			$options['Options'] = array(
								'job_bm_locations_list_per_page'=>array(
									'css_class'=>'list_per_page',					
									'title'=>'List Per Page',
									'option_details'=>'List Per Page',						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=>'20', // could be array
									),
									
								'job_bm_locations_listing_duration'=>array(
									'css_class'=>'listing_duration',					
									'title'=>'Listing Duration',
									'option_details'=>'Listing Duration',						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=>'30', // could be array
									),									
														

						);

			
			$options['Job Post'] = array(
								'job_bm_locations_account_required'=>array(
									'css_class'=>'account_required',					
									'title'=>'Account Required ?',
									'option_details'=>'Account Required',						
									'input_type'=>'checkbox', // text, radio, checkbox, select, 
									'input_values'=> array(), // could be array
									'input_args'=> array('yes'=>'Yes'),
									),

									
								'job_bm_locations_employer_account_role'=>array(
									'css_class'=>'employer_account_role',					
									'title'=>'Employer Account Role ?',
									'option_details'=>'Employer Account Role',						
									'input_type'=>'select', // text, radio, checkbox, select, 
									'input_values'=> array('employer'=>'Employer'), // could be array
									'input_args'=> $job_bm_locations_list_user_role,
									),									
									
								'job_bm_locations_applicant_account_role'=>array(
									'css_class'=>'applicant_account_role',					
									'title'=>'Applicant Account Role ?',
									'option_details'=>'Applicant Account Role',						
									'input_type'=>'select', // text, radio, checkbox, select, 
									'input_values'=> array('applicant'=>'applicant'), // could be array
									'input_args'=> $job_bm_locations_list_user_role,
									),										

								'job_bm_locations_salary_currency'=>array(
									'css_class'=>'salary_currency',					
									'title'=>'Salary currency ?',
									'option_details'=>'Salary currency',						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=> '$', // could be array
									),									
									
			
						);
			
			$options['Style'] = array(
								'job_bm_locations_featured_bg_color'=>array(
									'css_class'=>'featured_bg_color',					
									'title'=>'Featured Job Background Color ?',
									'option_details'=>'Featured Job Background Color',						
									'input_type'=>'text', // text, radio, checkbox, select, 
									'input_values'=> '#fff8bf', // could be array
									),
								
								'job_bm_locations_job_type_bg_color'=>array(
									'css_class'=>'job_type_bg_color',					
									'title'=>'Job Type Background Color ?',
									'option_details'=>'Job Type Background Color',						
									'input_type'=>'text-multi', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									'input_args'=> apply_filters('job_bm_locations_filters_job_type_bg_color', array('freelance'=>'#46a6ff','full-time'=>'#2ec274','internship'=>'#a066ff','part-time'=>'#ffc24d','temporary'=>'#ff5741'))
									),
									
								'job_bm_locations_job_status_bg_color'=>array(
									'css_class'=>'job_status_bg_color',					
									'title'=>'Job Status Background Color ?',
									'option_details'=>'Job Status Background Color',						
									'input_type'=>'text-multi', // text, radio, checkbox, select, 
									'input_values'=> '', // could be array
									'input_args'=> apply_filters('job_bm_locations_filters_job_status_bg_color', array('open'=>'#3ac170','closed'=>'#fa3218','filled'=>'#49a2ed','re-open'=>'#2fc2f9'))
									),								
								
								
								);
			
			
			
			$options = apply_filters( 'job_bm_locations_settings_options', $options );


			
			return $options;
		
		}
	
	
	public function job_bm_locations_settings_options_form(){
		
			global $post;
			
			$job_bm_locations_settings_options = $this->job_bm_locations_settings_options();
			//var_dump($job_settings_options);
			$html = '';
			
			$html.= '<div class="para-settings post-grid-settings">';			

			$html_nav = '';
			$html_box = '';
					
			$i=1;
			foreach($job_bm_locations_settings_options as $key=>$options){
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

				//$option_value =  get_post_meta( $post->ID, $option_key, true );
				$option_value =  get_option( $option_key );				
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
					
					
				elseif($option_info['input_type'] == 'text-multi'){
					
					$input_args = $option_info['input_args'];

									
					foreach($input_args as $input_args_key=>$input_args_values){
						
						if(empty($option_value[$input_args_key])){
							$option_value[$input_args_key] = $input_args[$input_args_key];
							}
							
							
						$html_box.= '<label>'.$input_args_key.'<br/><input class="job-bm-color" type="text" placeholder="" name="'.$option_key.'['.$input_args_key.']" value="'.$option_value[$input_args_key].'" /></label><br/>';	
						}
				
								

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
						$html_box.= '<label><input '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'['.$input_args_key.']"  type="checkbox" >'.$input_args_values.'</label><br/>';
						
						
						}
					
					
					}
					
				elseif($option_info['input_type'] == 'file'){
					
					$html_box.= '<input type="text" id="file_'.$option_key.'" name="'.$option_key.'" value="'.$option_value.'" /><br />';
					
					$html_box.= '<input id="upload_button_'.$option_key.'" class="upload_button_'.$option_key.' button" type="button" value="Upload File" />';					
					
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
	
	
	
}

new class_job_bm_locations_settings_page();







if(empty($_POST['job_bm_locations_hidden']))
	{


		$class_job_bm_locations_settings_page = new class_job_bm_locations_settings_page();
		
			$job_bm_locations_settings_options = $class_job_bm_locations_settings_page->job_bm_locations_settings_options();
			
			foreach($job_bm_locations_settings_options as $options_tab=>$options){
				
				foreach($options as $option_key=>$option_data){
					
					${$option_key} = get_option( $option_key );
		
					//var_dump($option_key);
					}
				}






	}
else
	{	
		if($_POST['job_bm_locations_hidden'] == 'Y') {
			//Form data sent

	
			$class_job_bm_locations_settings_page = new class_job_bm_locations_settings_page();
			
			$job_bm_locations_settings_options = $class_job_bm_locations_settings_page->job_bm_locations_settings_options();
			
			foreach($job_bm_locations_settings_options as $options_tab=>$options){
				
				foreach($options as $option_key=>$option_data){

					${$option_key} = stripslashes_deep($_POST[$option_key]);
					update_option($option_key, ${$option_key});
					//var_dump($option_key);
					
					}
				}
	
	
	
	

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.', 'job_bm_locations' ); ?></strong></p></div>
	
			<?php
			} 
	}
	
	

	
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(job_bm_locations_plugin_name.' Settings', 'job_bm_locations')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="job_bm_locations_hidden" value="Y">
        <?php settings_fields( 'job_bm_locations_plugin_options' );
				do_settings_sections( 'job_bm_locations_plugin_options' );
			
			
	$class_job_bm_locations_settings_page = new class_job_bm_locations_settings_page();
        echo $class_job_bm_locations_settings_page->job_bm_locations_settings_options_form(); 
	
			
			
		?>

    






<p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes','job_bm_locations' ); ?>" />
                </p>
		</form>


</div>
