<?php
if ( ! defined('ABSPATH')) exit;  // if direct access




add_action('job_bm_metabox_location_content_location_info','job_bm_metabox_location_content_location_info');


function job_bm_metabox_location_content_location_info($job_id){


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Location Information','job-board-manager-company-profile'); ?></div>
        <p class="section-description"></p>
    </div>


    <?php


}




add_action('job_bm_metabox_location_content_location_info','job_bm_metabox_location_content_country_code');

function job_bm_metabox_location_content_country_code($job_id){

    $settings_tabs_field = new settings_tabs_field();

    $class_job_bm_locations_functions = new class_job_bm_locations_functions();
    $job_bm_locations_country_list = $class_job_bm_locations_functions->job_bm_locations_country_list();



    $job_bm_location_country_code = get_post_meta($job_id, 'job_bm_location_country_code', true);

    $args = array(
        'id'		=> 'job_bm_location_country_code',
        //'parent'		=> '',
        'title'		=> __('Country','job-board-manager-company-profile'),
        'details'	=> __('Select country.','job-board-manager-company-profile'),
        'type'		=> 'select',
        'value'		=> $job_bm_location_country_code,
        'default'		=> '',
        'args'		=> $job_bm_locations_country_list,
    );

    $settings_tabs_field->generate_field($args);

}




add_action('job_bm_metabox_location_content_location_info','job_bm_metabox_location_content_latlang');

function job_bm_metabox_location_content_latlang($job_id){

    $settings_tabs_field = new settings_tabs_field();

    $class_job_bm_locations_functions = new class_job_bm_locations_functions();
    $job_bm_locations_country_list = $class_job_bm_locations_functions->job_bm_locations_country_list();



    $job_bm_location_latlang = get_post_meta($job_id, 'job_bm_location_latlang', true);

    $args = array(
        'id'		=> 'job_bm_location_latlang',
        //'parent'		=> '',
        'title'		=> __('Latitude, Longitude','job-board-manager-company-profile'),
        'details'	=> __('Write Latitude,Longitude, ex: 46.414382,10.013988','job-board-manager-company-profile'),
        'type'		=> 'text',
        'value'		=> $job_bm_location_latlang,
        'default'		=> '',
    );

    $settings_tabs_field->generate_field($args);

}












add_action('job_bm_metabox_location_content_admin','job_bm_metabox_location_content_admin_featured');

function job_bm_metabox_location_content_admin_featured($job_id){

    $settings_tabs_field = new settings_tabs_field();

    $job_bm_location_featured = get_post_meta($job_id, 'job_bm_location_featured', true);

    $args = array(
        'id'		=> 'job_bm_location_featured',
        //'parent'		=> '',
        'title'		=> __('Featured location','job-board-manager-company-profile'),
        'details'	=> __('Choose location as featured','job-board-manager-company-profile'),
        'type'		=> 'select',
        'value'		=> $job_bm_location_featured,
        'default'		=> '',
        'args'		=> array('no'=>__('No', 'job-board-manager-company-profile'),'yes'=>__('Yes', 'job-board-manager-company-profile')),
    );

    $settings_tabs_field->generate_field($args);

}









add_action('job_bm_metabox_save_location','job_bm_metabox_save_location');

function job_bm_metabox_save_location($job_id){


    $job_bm_location_country_code = isset($_POST['job_bm_location_country_code']) ? sanitize_text_field($_POST['job_bm_location_country_code']) : '';
    update_post_meta($job_id, 'job_bm_location_country_code', $job_bm_location_country_code);

    $job_bm_location_latlang = isset($_POST['job_bm_location_latlang']) ? sanitize_text_field($_POST['job_bm_location_latlang']) : '';
    update_post_meta($job_id, 'job_bm_location_latlang', $job_bm_location_latlang);


    $job_bm_location_featured = isset($_POST['job_bm_location_featured']) ? sanitize_text_field($_POST['job_bm_location_featured']) : '';
    update_post_meta($job_id, 'job_bm_location_featured', $job_bm_location_featured);



}

