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





add_action('job_bm_settings_tabs_content_locations', 'job_bm_settings_tabs_content_locations', 20);

if(!function_exists('job_bm_settings_tabs_content_locations')) {
    function job_bm_settings_tabs_content_locations($tab){

        $settings_tabs_field = new settings_tabs_field();

        $job_bm_locations_map_type = get_option('job_bm_locations_map_type');
        $job_bm_locations_api_key = get_option('job_bm_locations_api_key');

        $job_bm_locations_map_zoom = get_option('job_bm_locations_map_zoom');
        $job_bm_display_wiki_content = get_option('job_bm_display_wiki_content');



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Locations settings', 'job-board-manager-company-profile'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for locations.', 'job-board-manager-company-profile'); ?></p>

            <?php


            $args = array(
                'id'		=> 'job_bm_locations_map_type',
                //'parent'		=> '',
                'title'		=> __('Map Display','job-board-manager-company-profile'),
                'details'	=> __('Map Type in single location page header','job-board-manager-company-profile'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_locations_map_type,
                'default'		=> '',
                'args'		=>array('static'=>__('Static', 'job-board-manager-locations'),'dynamic'=>__('Dynamic', 'job-board-manager-locations'),'none'=>__('None', 'job-board-manager-locations')),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_locations_api_key',
                //'parent'		=> '',
                'title'		=> __('Map API key','job-board-manager-company-profile'),
                'details'	=> __('Put your gogole map api key here.','job-board-manager-company-profile'),
                'type'		=> 'text',
                'value'		=> $job_bm_locations_api_key,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_locations_map_zoom',
                //'parent'		=> '',
                'title'		=> __('Map zoom level','job-board-manager-company-profile'),
                'details'	=> __('Map zoom in single location page header, value (0-20)','job-board-manager-company-profile'),
                'type'		=> 'text',
                'value'		=> $job_bm_locations_map_zoom,
                'default'		=> '12',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'job_bm_display_wiki_content',
                //'parent'		=> '',
                'title'		=> __('Display Content from Wikipedia','job-board-manager-company-profile'),
                'details'	=> __('Location content on single page display from wikipidea when empty.','job-board-manager-company-profile'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $job_bm_display_wiki_content,
                'default'		=> '',
                'args'		=>array('yes'=>__('Yes', 'job-board-manager-locations'),'no'=>__('No', 'job-board-manager-locations')),
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

        $job_bm_locations_map_type = isset($_POST['job_bm_locations_map_type']) ? sanitize_text_field($_POST['job_bm_locations_map_type']) : '';
        update_option('job_bm_locations_map_type', $job_bm_locations_map_type);


        $job_bm_locations_api_key = isset($_POST['job_bm_locations_api_key']) ? sanitize_text_field($_POST['job_bm_locations_api_key']) : '';
        update_option('job_bm_locations_api_key', $job_bm_locations_api_key);

        $job_bm_locations_map_zoom = isset($_POST['job_bm_locations_map_zoom']) ? sanitize_text_field($_POST['job_bm_locations_map_zoom']) : '';
        update_option('job_bm_locations_map_zoom', $job_bm_locations_map_zoom);

        $job_bm_display_wiki_content = isset($_POST['job_bm_display_wiki_content']) ? sanitize_text_field($_POST['job_bm_display_wiki_content']) : '';
        update_option('job_bm_display_wiki_content', $job_bm_display_wiki_content);


    }
}