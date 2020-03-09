<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_filter('job_bm_settings_tabs','job_bm_settings_tabs_locations');
function job_bm_settings_tabs_locations($job_bm_settings_tab){

    $job_bm_settings_tab[] = array(
        'id' => 'locations',
        'title' => sprintf(__('%s Locations','job-board-manager-locations'),'<i class="fas fa-map-marked-alt"></i>'),
        'priority' => 10,
        'active' => false,
    );

    return $job_bm_settings_tab;

}



add_action('job_bm_settings_tabs_content_pages', 'job_bm_settings_tabs_content_pages_locations', 20);

if(!function_exists('job_bm_settings_tabs_content_pages_locations')) {
    function job_bm_settings_tabs_content_pages_locations($tab){

        $settings_tabs_field = new settings_tabs_field();

        $job_bm_location_submit_page_id = get_option('job_bm_location_submit_page_id');

        $job_bm_location_edit_page_id = get_option('job_bm_location_edit_page_id');



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Location page settings', 'job-board-manager-locations'); ?></div>
            <p class="description section-description"><?php echo __('Choose option location for pages.', 'job-board-manager-locations'); ?></p>

            <?php


            $args = array(
                'id'		=> 'job_bm_location_submit_page_id',
                //'parent'		=> '',
                'title'		=> __('Location submit page','job-board-manager-locations'),
                'details'	=> __('Choose the page for location submit page, where the shortcode <code>[job_bm_location_submit_form]</code> used.','job-board-manager-locations'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_location_submit_page_id,
                'default'		=> '',
                'args'		=> job_bm_page_list_id(),
            );

            $settings_tabs_field->generate_field($args);




//            $args = array(
//                'id'		=> 'job_bm_location_edit_page_id',
//                //'parent'		=> '',
//                'title'		=> __('Location edit page','job-board-manager-locations'),
//                'details'	=> __('Choose the page for location edit page, where the shortcode <code>[job_bm_location_edit_form]</code> used.','job-board-manager-locations'),
//                'type'		=> 'select',
//                //'multiple'		=> true,
//                'value'		=> $job_bm_location_edit_page_id,
//                'default'		=> '',
//                'args'		=> job_bm_page_list_id(),
//            );
//
//            $settings_tabs_field->generate_field($args);





            ?>


        </div>
        <?php


    }
}



add_action('job_bm_settings_tabs_content_locations', 'job_bm_settings_tabs_content_locations', 20);

if(!function_exists('job_bm_settings_tabs_content_locations')) {
    function job_bm_settings_tabs_content_locations($tab){

        $settings_tabs_field = new settings_tabs_field();

        $job_bm_locations_map_type = get_option('job_bm_locations_map_type');
        $job_bm_locations_api_key = get_option('job_bm_locations_api_key');

        $job_bm_locations_map_zoom = get_option('job_bm_locations_map_zoom');
        $job_bm_display_wiki_content = get_option('job_bm_display_wiki_content');
        $job_bm_location_submit_recaptcha = get_option('job_bm_location_submit_recaptcha');
        $job_bm_location_submit_post_status = get_option('job_bm_location_submit_post_status');
        $job_bm_location_submit_redirect = get_option('job_bm_location_submit_redirect');


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Locations settings', 'job-board-manager-locations'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for locations.', 'job-board-manager-locations'); ?></p>

            <?php


            $args = array(
                'id'		=> 'job_bm_locations_map_type',
                //'parent'		=> '',
                'title'		=> __('Map Display','job-board-manager-locations'),
                'details'	=> __('Map Type in single location page header','job-board-manager-locations'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_locations_map_type,
                'default'		=> '',
                'args'		=>array('static'=>__('Static', 'job-board-manager-locations'),'dynamic'=>__('Dynamic', 'job-board-manager-locations'),'cover_image'=>__('Cover image', 'job-board-manager-locations'),'none'=>__('None', 'job-board-manager-locations')),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_locations_api_key',
                //'parent'		=> '',
                'title'		=> __('Map API key','job-board-manager-locations'),
                'details'	=> __('Put your gogole map api key here.','job-board-manager-locations'),
                'type'		=> 'text',
                'value'		=> $job_bm_locations_api_key,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_locations_map_zoom',
                //'parent'		=> '',
                'title'		=> __('Map zoom level','job-board-manager-locations'),
                'details'	=> __('Map zoom in single location page header, value (0-20)','job-board-manager-locations'),
                'type'		=> 'text',
                'value'		=> $job_bm_locations_map_zoom,
                'default'		=> '12',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_display_wiki_content',
                //'parent'		=> '',
                'title'		=> __('Display Content from Wikipedia','job-board-manager-locations'),
                'details'	=> __('Location content on single page display from wikipidea when empty.','job-board-manager-locations'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_display_wiki_content,
                'default'		=> '',
                'args'		=>array('yes'=>__('Yes', 'job-board-manager-locations'),'no'=>__('No', 'job-board-manager-locations')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'job_bm_location_submit_recaptcha',
                //'parent'		=> '',
                'title'		=> __('reCAPTCHA enable','job-board-manager-locations'),
                'details'	=> __('Enable reCAPTCHA to protect spam on location submit form.','job-board-manager-locations'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_location_submit_recaptcha,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','job-board-manager-locations'), 'no'=>__('No','job-board-manager-locations'),),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_location_submit_post_status',
                //'parent'		=> '',
                'title'		=> __('Submitted location status','job-board-manager-locations'),
                'details'	=> __('Choose location status for newly submitted companies.','job-board-manager-locations'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_location_submit_post_status,
                'default'		=> '',
                'args'		=> array( 'draft'=>__('Draft','job-board-manager-locations'), 'pending'=>__('Pending','job-board-manager-locations'), 'publish'=>__('Published','job-board-manager-locations'), 'private'=>__('Private','job-board-manager-locations'), 'trash'=>__('Trash','job-board-manager-locations')),
            );

            $settings_tabs_field->generate_field($args);





            $page_list = job_bm_page_list_id();
            //$page_list = array_merge($page_list, array('job_preview'=>'Job Preview'));

            $page_list['location_preview'] = __('-- Location Preview --', 'job-board-manager-locations');
            $page_list['location_link'] = __('-- Location Link --', 'job-board-manager-locations');

            $args = array(
                'id'		=> 'job_bm_location_submit_redirect',
                //'parent'		=> '',
                'title'		=> __('Redirect after location submit','job-board-manager-locations'),
                'details'	=> __('Redirect other link after location submitted','job-board-manager-locations'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_location_submit_redirect,
                'default'		=> '',
                'args'		=> $page_list,
            );

            $settings_tabs_field->generate_field($args);



            ?>


        </div>
        <?php


    }
}


add_action('job_bm_settings_save', 'job_bm_settings_save_locations', 20);

if(!function_exists('job_bm_settings_save_locations')) {
    function job_bm_settings_save_locations($tab){

        $job_bm_location_submit_page_id = isset($_POST['job_bm_location_submit_page_id']) ? sanitize_text_field($_POST['job_bm_location_submit_page_id']) : '';
        update_option('job_bm_location_submit_page_id', $job_bm_location_submit_page_id);



        $job_bm_locations_map_type = isset($_POST['job_bm_locations_map_type']) ? sanitize_text_field($_POST['job_bm_locations_map_type']) : '';
        update_option('job_bm_locations_map_type', $job_bm_locations_map_type);


        $job_bm_locations_api_key = isset($_POST['job_bm_locations_api_key']) ? sanitize_text_field($_POST['job_bm_locations_api_key']) : '';
        update_option('job_bm_locations_api_key', $job_bm_locations_api_key);

        $job_bm_locations_map_zoom = isset($_POST['job_bm_locations_map_zoom']) ? sanitize_text_field($_POST['job_bm_locations_map_zoom']) : '';
        update_option('job_bm_locations_map_zoom', $job_bm_locations_map_zoom);

        $job_bm_display_wiki_content = isset($_POST['job_bm_display_wiki_content']) ? sanitize_text_field($_POST['job_bm_display_wiki_content']) : '';
        update_option('job_bm_display_wiki_content', $job_bm_display_wiki_content);

        $job_bm_location_submit_recaptcha = isset($_POST['job_bm_location_submit_recaptcha']) ? sanitize_text_field($_POST['job_bm_location_submit_recaptcha']) : '';
        update_option('job_bm_location_submit_recaptcha', $job_bm_location_submit_recaptcha);

        $job_bm_location_submit_post_status = isset($_POST['job_bm_location_submit_post_status']) ? sanitize_text_field($_POST['job_bm_location_submit_post_status']) : '';
        update_option('job_bm_location_submit_post_status', $job_bm_location_submit_post_status);

        $job_bm_location_submit_redirect = isset($_POST['job_bm_location_submit_redirect']) ? sanitize_text_field($_POST['job_bm_location_submit_redirect']) : '';
        update_option('job_bm_location_submit_redirect', $job_bm_location_submit_redirect);


    }
}



















/*Right panel*/

add_action('job_bm_settings_tabs_right_panel_locations', 'job_bm_settings_tabs_right_panel_locations');

if(!function_exists('job_bm_settings_tabs_right_panel_locations')) {
    function job_bm_settings_tabs_right_panel_locations($id){

        ?>
        <h3>Help & Support</h3>
        <p>Please read documentation for customize Job Board Manger - Locations</p>
        <a target="_blank" class="button" href="https://www.pickplugins.com/documentation/job-board-manager-locations/?ref=dashboard">Documentation</a>

        <p>If you found any issue could not manage to solve yourself, please let us know and post your issue on forum.</p>
        <a target="_blank" class="button" href="https://www.pickplugins.com/forum/?ref=dashboard">Create Ticket</a>

        <h3>Write Reviews</h3>
        <p>If you found Job Board Manger - Locations help you to build something useful, please help us by
            providing your feedback and five star reviews on plugin page.</p>
        <a target="_blank" class="button" href="https://wordpress.org/support/plugin/job-board-manager-locations/reviews/#new-post">Rate Us <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></a>

        <h3>Shortcodes</h3>
        <p>
            <code>[job_bm_top_locations]</code> <br> Display top locations by job count, <br><a href="http://www.pickplugins.com/demo/job-board-manager/top-locations/">Demo</a>
        </p>

        <p>
            <code>[job_bm_location_submit_form]</code> <br> Display location submit form. <br><a href="http://www.pickplugins.com/demo/job-board-manager/location-submit-form/">Demo</a>
        </p>

        <p>
            <code>[job_bm_jobs_in_map]</code> <br> Display all jobs in Google map.<br><a href="http://www.pickplugins.com/demo/job-board-manager/jobs-in-map/">Demo</a>
        </p>
        <p>
            <code>[job_bm_expandable_joblist]</code> <br> Display expandable job list by country & location. <br><a href="http://www.pickplugins.com/demo/job-board-manager/location-expandable-job-list/">Demo</a>
        </p>





        <?php

    }
}











