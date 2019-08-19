<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	$job_bm_account_required_post_job = get_option('job_bm_account_required_post_job');


	if ( is_user_logged_in() ) {
		$userid = get_current_user_id();
	} else {
		$userid = 0;
		if( $job_bm_account_required_post_job=='yes'){
			echo sprintf (__('Please <a href="%s">login</a> to submit location.','job-board-manager-locations'), wp_login_url( $_SERVER['REQUEST_URI'] ) ) ;
			return;
		}
	}
	
	$class_functions	= new class_job_bm_locations_functions();
	$class_pickform		= new class_pickform();
	$post_input_fields	= $class_functions->post_type_input_fields();
	
	
	do_action('job_bm_locations_action_job_submit_main');
	
	// echo '<pre>'; print_r( $_POST ); echo '</pre>';
	
	
	$post_status	= get_option( 'job_bm_locations_submitted_status', 'pending' );
	$reCAPTCHA_chk	= get_option( 'job_bm_reCAPTCHA_enable', 'no' );
	
	$post_title 	= $post_input_fields['post_title'];
	$post_content 	= $post_input_fields['post_content'];	
	$meta_fields 	= $post_input_fields['meta_fields'];
	$recaptcha 		= $post_input_fields['recaptcha'];	?>
	
	<div class="location-submit pickform">
	
	
	<div class="validations">
    <?php
		if( isset($_POST['post_location_hidden']) ) {

		$validations = array();
		
		if( empty( $_POST['post_title'] ) && $post_title['required'] == 'yes' ) {
			
			$validations['post_title'] = '';
			echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$post_title['title'].'</b> '.__('missing','job-board-manager-locations').'.</div>';
		}
		
		if( empty($_POST['post_content']) && $post_content['required'] == 'yes' ) {
			
			 $validations['post_content'] = '';
			 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$post_content['title'].'</b> '.__('missing','job-board-manager-locations').'.</div>';
		}		
		
		if($reCAPTCHA_chk=='yes'){
			if(empty($_POST['g-recaptcha-response'])){
				
				 $validations['recaptcha'] = '';
				 echo '<div class="failed"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$recaptcha['title'].'</b> '.__('missing','job-board-manager-locations').'.</div>';
			}
		}
		
		
		if( !empty($meta_fields) )
		foreach( $meta_fields as $field_key => $field_details ) {
			
			if( isset( $_POST[$field_key] ) )
			$valid = $class_pickform->validations($field_details, $_POST[$field_key]);
			
			if( !empty( $valid ) && $field_details['required'] == 'yes' ) {
				$validations[$field_key] = '';
				echo '<div class="failed"><b><i class="fa fa-exclamation-circle"></i></b> '.sprintf(__( '<b>%s</b> missing', 'job-board-manager-locations' ), $field_details['title'] ).'</div>';
			}
		}
			
			
		
		if( empty( $validations ) ) {
			
			$post_title_val 	= $class_pickform->sanitizations($_POST['post_title'], 'text');
			$post_content_val 	= $class_pickform->sanitizations($_POST['post_content'], 'wp_editor');		
				
			$location_ID = wp_insert_post( 
				array(
					'post_title'    => $post_title_val,
					'post_content'  => $post_content_val,
					'post_status'   => $post_status,
					'post_type'   	=> 'location',
					'post_author'   => $userid,
				)
			);
			
			// echo '<pre>'; print_r( $meta_fields ); echo '</pre>';
			
			foreach( $meta_fields as $meta_key => $meta_details ) {
				
				$meta_key_val = $class_pickform->sanitizations( $_POST[$meta_key], $meta_details['input_type'] );
				
				update_post_meta( $location_ID, "$meta_key", $meta_key_val );
			}
			
			echo '<div class="success"><i class="fa fa-check"></i> '.__('Location Submitted.', 'job-board-manager-locations').'</div>';
			echo '<div class="success"><i class="fa fa-check"></i> '.__('Submission Status:', 'job-board-manager-locations').' '.ucfirst($post_status).'</div>';
		
		} else {
			
			$post_title 	= array_merge( $post_title , array( 'input_values' => $class_pickform->sanitizations($_POST['post_title'], 'text')));
			$post_content 	= array_merge( $post_content, array( 'input_values' => $class_pickform->sanitizations($_POST['post_content'], 'wp_editor')));	
			
			foreach( $meta_fields as $field_key => $field_details ) {
		
				$meta_key_val = $class_pickform->sanitizations( $_POST[$field_key], $field_details['input_type'] );
				
				$meta_fields[$field_key] = array_merge( $meta_fields[$field_key], array( 'input_values' => $meta_key_val ) );
			}
			
		}
		
	} ?>
        
        
    </div>
	
	
	    <form enctype="multipart/form-data"   method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="post_location_hidden" value="Y" />
	
		<?php
		
		
		echo '<div class="option">';
		echo $class_pickform->field_set($post_title);
		echo '</div>';
		
		echo '<div class="option">';
		echo $class_pickform->field_set($post_content);
		echo '</div>';		
		
	
		if( !empty($meta_fields) )
		foreach( $meta_fields as $field_key => $field_details ) {
		
			echo '<div class="option">';
			echo $class_pickform->field_set( $field_details );
			echo '</div>';
		}
		
		
		if( $reCAPTCHA_chk == 'yes' ) {
			echo '<div class="option">';
			echo $class_pickform->field_set($recaptcha);
			echo '</div>';
		}
		
		
		
		?>
		
		<div class="location-submit-button"> 
			<?php wp_nonce_field( 'job_bm_locations' ); ?>
			<input type="submit"  name="submit" value="<?php _e('Submit', 'job-board-manager-locations'); ?>" />
		</div>
		
		
		
		</form>
	</div>
	