<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 


add_filter('job_bm_dashboard_tabs','job_bm_dashboard_tabs_locations');
function job_bm_dashboard_tabs_locations($tabs){

    $tabs['my_locations'] =array(
        'title'=>__('My locations', 'job-board-manager-locations'),
        'priority'=>5,
    );

    return $tabs;

}







add_action('job_bm_dashboard_tabs_content_my_locations', 'job_bm_dashboard_tabs_content_my_locations');

if(!function_exists('job_bm_dashboard_tabs_content_my_locations')){
    function job_bm_dashboard_tabs_content_my_locations(){

        echo do_shortcode('[job_bm_my_locations]');

    }
}


		