<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 



/* Display question title field */

add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_title', 0);

function job_bm_location_submit_form_title(){

    $post_title = isset($_POST['post_title']) ? sanitize_text_field($_POST['post_title']) : "";

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company name','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $post_title; ?>" name="post_title">
            <p class="field-details"><?php echo __('Write your location name','job-board-manager-location-profile');
            ?></p>
        </div>
    </div>
    <?php
}


/* Display question details input field*/

add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_content', 10);

function job_bm_location_submit_form_content(){

    $field_id = 'post_content';
    $allowed_html = apply_filters('job_bm_location_submit_allowed_html_tags', array());
    $post_content = isset($_POST['post_content']) ? wp_kses($_POST['post_content'], $allowed_html) : "";


    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company description','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <?php
            ob_start();
            wp_editor( $post_content, $field_id, $settings = array('textarea_name'=>$field_id,
                'media_buttons'=>false,'wpautop'=>true,'editor_height'=>'200px', ) );
            echo ob_get_clean();

            ?>

            <p class="field-details"><?php echo __('Write your location details.','job-board-manager-location-profile'); ?></p>

        </div>
    </div>
    <?php
}




/* Display category input field  */

//add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_categories', 20);

function job_bm_location_submit_form_categories(){

    $location_category = isset($_POST['location_category']) ? sanitize_text_field($_POST['location_category']) : "";

    $categories = get_terms( array(
        'taxonomy' => 'location_category',
        'hide_empty' => false,
    ) );

    $terms = array();

    //var_dump($categories);



    if(!empty($categories)) {
        foreach ($categories as $category) {

            $name = $category->name;
            $cat_ID = $category->term_id;
            $terms[$cat_ID] = $name;
        }
    }

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company category','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <select name="location_category">
                <?php
                if(!empty($terms)):
                    foreach ($terms as $term_id => $term_name){

                        $selected = ($location_category == $term_id) ? 'selected' : '';

                        ?>
                        <option <?php echo $selected; ?> value="<?php echo esc_attr($term_id); ?>"><?php echo esc_html
                            ($term_name); ?></option>
                        <?php
                    }
                endif;
                ?>
            </select>
            <p class="field-details"><?php echo __('Select location category.','job-board-manager-location-profile'); ?></p>

        </div>
    </div>
    <?php
}






add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_job_info_title', 30);


function job_bm_location_submit_form_job_info_title(){


    ?>
    <div class="form-field-wrap ">
        <div class="field-separator"><?php echo __('Company Information','job-board-manager-location-profile'); ?></div>
    </div>
    <?php
}











/* Display vacancies input field  */

add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_tagline', 30);


function job_bm_location_submit_form_tagline(){

    $job_bm_cp_tagline = isset($_POST['job_bm_cp_tagline']) ? sanitize_text_field($_POST['job_bm_cp_tagline']) : "";

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company tag-line','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_tagline; ?>" name="job_bm_cp_tagline">
            <p class="field-details"><?php echo __('Write your location tag-line','job-board-manager-location-profile');
                ?></p>
        </div>
    </div>
    <?php
}




/* Display years_experience input field  */

add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_mission', 30);

function job_bm_location_submit_form_mission(){

    $job_bm_cp_mission = isset($_POST['job_bm_cp_mission']) ? sanitize_text_field($_POST['job_bm_cp_mission']) : "";

    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Company mission','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_mission; ?>" name="job_bm_cp_mission">
            <p class="field-details"><?php echo __('Write location mission.','job-board-manager-location-profile');
                ?></p>
        </div>
    </div>
    <?php
}



/* Display job_type input field  */

add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_country', 30);

function job_bm_location_submit_form_country(){

    $class_job_bm_cp_functions = new class_job_bm_cp_functions();
    $job_bm_cp_country_list = $class_job_bm_cp_functions->job_bm_cp_country_list();

    $job_bm_cp_country = isset($_POST['job_bm_cp_country']) ? sanitize_text_field($_POST['job_bm_cp_country']) : "";


    ?>
    <div class="form-field-wrap">
        <div class="field-title"><?php echo __('Country','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <select name="job_bm_cp_country" >
                <?php
                if(!empty($job_bm_cp_country_list)):
                    foreach ($job_bm_cp_country_list as $job_type => $job_type_name){

                        $selected = ($job_bm_cp_country == $job_type) ? 'selected' : '';

                        ?>
                        <option <?php echo $selected; ?> value="<?php echo esc_attr($job_type); ?>"><?php echo esc_html
                            ($job_type_name); ?></option>
                        <?php
                    }
                endif;
                ?>
            </select>
            <p class="field-details"><?php echo __('Select location country.','job-board-manager-location-profile'); ?></p>

        </div>
    </div>
    <?php
}


add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_city', 30);

function job_bm_location_submit_form_city(){

    $job_bm_cp_city = isset($_POST['job_bm_cp_city']) ? sanitize_text_field($_POST['job_bm_cp_city']) : "";

    ?>
    <div class="form-field-wrap ">
        <div class="field-title"><?php echo __('Company city','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_city; ?>" name="job_bm_cp_city">
            <p class="field-details"><?php echo __('Write location city','job-board-manager-location-profile');
                ?></p>
        </div>
    </div>
    <?php
}



add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_address', 30);

function job_bm_location_submit_form_address(){

    $job_bm_cp_address = isset($_POST['job_bm_cp_address']) ? sanitize_text_field($_POST['job_bm_cp_address']) : "";

    ?>
    <div class="form-field-wrap " >
        <div class="field-title"><?php echo __('Company address','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <input placeholder="" type="text" value="<?php echo $job_bm_cp_address; ?>" name="job_bm_cp_address">
            <p class="field-details"><?php echo __('Write location address','job-board-manager-location-profile');
                ?></p>
        </div>
    </div>
    <?php
}



add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_logo', 30);
function job_bm_location_submit_form_logo(){

    $job_bm_cp_logo = isset($_POST['job_bm_cp_logo']) ? sanitize_text_field($_POST['job_bm_cp_logo']) : job_bm_plugin_url."assets/front/images/placeholder.png";

    ?>
    <div class="form-field-wrap job-bm-media-upload">
        <div class="field-title"><?php echo __('Company logo','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <div class="media-preview-wrap" style="">
                <img class="media-preview" src="<?php echo $job_bm_cp_logo; ?>" style="width:100%;box-shadow: none;"/>
            </div>

            <input placeholder="" type="text" value="<?php echo $job_bm_cp_logo; ?>" name="job_bm_cp_logo">
            <span class="media-upload " id=""><?php echo __('Upload','job-board-manager-location-profile');?></span>
            <!--            <span class="media-clear" id="">--><?php //echo __('Clear','job-board-manager-location-profile');?><!--</span>-->

            <p class="field-details"><?php echo __('Upload location logo','job-board-manager-location-profile');
                ?></p>
        </div>
    </div>
    <?php
}


add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_cover', 30);
function job_bm_location_submit_form_cover(){

    $job_bm_location_cover = isset($_POST['job_bm_location_cover']) ? sanitize_text_field($_POST['job_bm_location_cover']) : job_bm_plugin_url."assets/front/images/placeholder.png";

    ?>
    <div class="form-field-wrap job-bm-media-upload">
        <div class="field-title"><?php echo __('Company cover image','job-board-manager-location-profile'); ?></div>
        <div class="field-input">
            <div class="media-preview-wrap" style="">
                <img class="media-preview" src="<?php echo $job_bm_location_cover; ?>" style="width:100%;box-shadow: none;"/>
            </div>

            <input placeholder="" type="text" value="<?php echo $job_bm_location_cover; ?>" name="job_bm_cp_logo">
            <span class="media-upload " id=""><?php echo __('Upload','job-board-manager-location-profile');?></span>
            <!--            <span class="media-clear" id="">--><?php //echo __('Clear','job-board-manager-location-profile');?><!--</span>-->

            <p class="field-details"><?php echo __('Upload location cover image','job-board-manager-location-profile');
                ?></p>
        </div>
    </div>
    <?php
}

















/* display reCaptcha */

add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_recaptcha', 60);

function job_bm_location_submit_form_recaptcha(){

    $job_bm_location_submit_recaptcha		= get_option('job_bm_location_submit_recaptcha');
    $job_bm_reCAPTCHA_site_key		        = get_option('job_bm_reCAPTCHA_site_key');

    if($job_bm_location_submit_recaptcha != 'yes'){
        return;
    }

    ?>
    <div class="form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">
            <div class="g-recaptcha" data-sitekey="<?php echo $job_bm_reCAPTCHA_site_key; ?>"></div>
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <p class="field-details"><?php echo __('Please prove you are human.','job-board-manager-location-profile'); ?></p>

        </div>
    </div>
    <?php
}


/* Display nonce  */

add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_nonce' );

function job_bm_location_submit_form_nonce(){

    ?>
    <div class="form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">

            <?php wp_nonce_field( 'job_bm_location_submit_nonce','job_bm_location_submit_nonce' ); ?>

        </div>
    </div>
    <?php
}


/* Display submit button */

add_action('job_bm_location_submit_form', 'job_bm_location_submit_form_submit', 90);

function job_bm_location_submit_form_submit(){

    ?>
    <div class="form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">
            <input type="submit"  name="submit" value="<?php _e('Submit', 'job-board-manager-location-profile'); ?>" />
        </div>
    </div>
    <?php
}





/* Process the submitted data  */

add_action('job_bm_location_submit_data', 'job_bm_location_submit_data');

function job_bm_location_submit_data($post_data){

    $job_bm_location_submit_recaptcha		    = get_option('job_bm_location_submit_recaptcha');
    $job_bm_location_submit_account_required 	= get_option('job_bm_location_submit_account_required', 'yes');
    $job_bm_location_submit_post_status 		= get_option('job_bm_location_submit_post_status', 'pending' );
    $job_bm_job_login_page_id           = get_option('job_bm_job_login_page_id');
    $dashboard_page_url                 = get_permalink($job_bm_job_login_page_id);


    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
    } else {
        $user_id = 0;
    }

    $error = new WP_Error();




    if(empty($post_data['post_title'])){

        $error->add( 'post_title', __( 'ERROR: Company name is empty.', 'job-board-manager-location-profile' ) );
    }

    if(empty($post_data['post_content'])){

        $error->add( 'post_content', __( 'ERROR: Company details is empty.', 'job-board-manager-location-profile' ) );
    }

    if(empty($post_data['job_bm_cp_tagline'])){

        $error->add( 'job_bm_cp_tagline', __( 'ERROR: Company tag-line is empty.', 'job-board-manager-location-profile' ) );
    }



    if(empty($post_data['job_bm_cp_size'])){

        $error->add( 'job_bm_cp_size', __( 'ERROR: Company size is empty.', 'job-board-manager-location-profile' ) );
    }






    if(empty($post_data['job_bm_cp_logo'])){

        $error->add( 'job_bm_cp_logo', __( 'ERROR: Company logo is empty.', 'job-board-manager-location-profile' ) );
    }

    if(empty($post_data['g-recaptcha-response']) && $job_bm_location_submit_recaptcha =='yes'){

        $error->add( 'g-recaptcha-response', __( 'ERROR: reCaptcha test failed.', 'job-board-manager-location-profile' ) );
    }

    if($job_bm_location_submit_account_required == 'yes' && !is_user_logged_in()){

        $error->add( 'login',  sprintf (__('ERROR: Please <a target="_blank" href="%s">login</a> to submit question.',
            'job-board-manager-location-profile'), $dashboard_page_url ));
    }

    if(! isset( $_POST['job_bm_location_submit_nonce'] ) || ! wp_verify_nonce( $_POST['job_bm_location_submit_nonce'], 'job_bm_location_submit_nonce' ) ){

        $error->add( '_wpnonce', __( 'ERROR: security test failed.', 'job-board-manager-location-profile' ) );
    }



    $errors = apply_filters( 'job_bm_location_submit_errors', $error, $post_data );






    if ( !$error->has_errors() ) {

        $allowed_html = array();

        $post_title = isset($post_data['post_title']) ? $post_data['post_title'] :'';
        $post_content = isset($post_data['post_content']) ? wp_kses($post_data['post_content'], $allowed_html) : "";


        $location_id = wp_insert_post(
            array(
                'post_title'    => $post_title,
                'post_content'  => $post_content,
                'post_status'   => $job_bm_location_submit_post_status,
                'post_type'   	=> 'location',
                'post_author'   => $user_id,
            )
        );

        do_action('job_bm_location_submitted', $location_id, $post_data);

    }
    else{

        $error_messages = $error->get_error_messages();

        ?>
        <div class="errors">
            <?php

            if(!empty($error_messages))
            foreach ($error_messages as $message){
                ?>
                <div class="job-bm-error"><?php echo $message; ?></div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}


/* Display save data after submitted question */

add_action('job_bm_location_submitted', 'job_bm_location_submitted_save_data', 90, 2);

function job_bm_location_submitted_save_data($location_id, $post_data){

    $user_id = get_current_user_id();

    $location_category = isset($post_data['location_category']) ? sanitize_text_field($post_data['location_category']) : "";
    $job_bm_cp_tagline = isset($post_data['job_bm_cp_tagline']) ? sanitize_text_field($post_data['job_bm_cp_tagline']) : "";
    $job_bm_cp_mission = isset($post_data['job_bm_cp_mission']) ? sanitize_text_field($post_data['job_bm_cp_mission']) : "";
    $job_bm_cp_country = isset($post_data['job_bm_cp_country']) ? sanitize_text_field($post_data['job_bm_cp_country']) : "";
    $job_bm_cp_city = isset($post_data['job_bm_cp_city']) ? sanitize_text_field($post_data['job_bm_cp_city']) : "";
    $job_bm_cp_address = isset($post_data['job_bm_cp_address']) ? sanitize_text_field($post_data['job_bm_cp_address']) : "";
    $job_bm_cp_website = isset($post_data['job_bm_cp_website']) ? sanitize_text_field($post_data['job_bm_cp_website']) : "";
    $job_bm_cp_founded = isset($post_data['job_bm_cp_founded']) ? sanitize_text_field($post_data['job_bm_cp_founded']) : "";
    $job_bm_cp_size = isset($post_data['job_bm_cp_size']) ? sanitize_text_field($post_data['job_bm_cp_size']) : "";
    $job_bm_cp_logo = isset($post_data['job_bm_cp_logo']) ? sanitize_text_field($post_data['job_bm_cp_logo']) : "";
    $job_bm_location_cover = isset($post_data['job_bm_location_cover']) ? esc_url_raw($post_data['job_bm_location_cover']) : "";




    wp_set_post_terms( $location_id, $location_category, 'location_category' );


    update_post_meta($location_id, 'job_bm_cp_tagline', $job_bm_cp_tagline);
    update_post_meta($location_id, 'job_bm_cp_mission', $job_bm_cp_mission);
    update_post_meta($location_id, 'job_bm_cp_country', $job_bm_cp_country);
    update_post_meta($location_id, 'job_bm_cp_city', $job_bm_cp_city);
    update_post_meta($location_id, 'job_bm_cp_address', $job_bm_cp_address);
    update_post_meta($location_id, 'job_bm_cp_website', $job_bm_cp_website);
    update_post_meta($location_id, 'job_bm_cp_founded', $job_bm_cp_founded);
    update_post_meta($location_id, 'job_bm_cp_size', $job_bm_cp_size);
    update_post_meta($location_id, 'job_bm_cp_logo', $job_bm_cp_logo);
    update_post_meta($location_id, 'job_bm_location_cover', $job_bm_location_cover);


}






/* Display success message after submitted question */

add_action('job_bm_location_submitted', 'job_bm_location_submitted_message', 80, 2);

function job_bm_location_submitted_message($location_id, $post_data){

    ?>
    <div class="job-submitted success">
        <?php echo apply_filters('job_bm_location_submitted_thank_you', _e('Thanks for submit your location, we will review soon.', 'job-board-manager-location-profile')); ?>
    </div>
    <?php


}







add_action('job_bm_location_submitted', 'job_bm_location_submitted_redirect', 99999, 2);

function job_bm_location_submitted_redirect($location_id, $post_data){

    $job_bm_location_submit_redirect 	= get_option('job_bm_location_submit_redirect');




    if(!empty($job_bm_location_submit_redirect)):

        if($job_bm_location_submit_redirect =='location_preview'){
            $redirect_page_url = get_preview_post_link($location_id);
        }
        elseif($job_bm_location_submit_redirect =='location_link'){
            $redirect_page_url = get_permalink($location_id);
        }
        else{
            $job_bm_job_login_page_id 	= get_option('job_bm_job_login_page_id');
            $redirect_page_url 					= get_permalink($job_bm_job_login_page_id);
        }

        ?>
        <script>
            jQuery(document).ready(function($) {
                window.location.href = '<?php echo $redirect_page_url; ?>';
            })
        </script>
    <?php

    endif;



//    if ( wp_safe_redirect($redirect_page_url) ) {
//        exit;
//    }


}

