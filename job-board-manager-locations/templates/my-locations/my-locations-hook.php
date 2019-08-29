<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('job_bm_my_locations','job_bm_my_locations_title');

if(!function_exists('job_bm_my_locations_title')):

    function job_bm_my_locations_title(){

        $job_bm_location_submit_page_id                       = get_option( 'job_bm_location_submit_page_id' );
        $location_submit_page_url          = get_permalink($job_bm_location_submit_page_id);



        ?>
            <div class="nav-head">
                <?php echo __('My Locations', 'job-board-manager-locations'); ?>
                <a target="_blank" title="<?php echo __('Add Location', 'job-board-manager-locations'); ?>" class="submit-location" href="<?php echo $location_submit_page_url; ?>"><i class="far fa-plus-square"></i> <?php echo __('Add Location', 'job-board-manager-locations'); ?></a>
            </div>

        <?php

    }

endif;




add_action('job_bm_my_locations','job_bm_my_locations_list');

if(!function_exists('job_bm_my_locations_list')):

    function job_bm_my_locations_list(){
        ?>

            <?php


            $date_format                        = get_option( 'date_format' );
            $job_bm_can_user_edit_published_jobs  = get_option( 'job_bm_can_user_edit_published_jobs','no' );
            $job_bm_can_user_delete_jobs  = get_option( 'job_bm_can_user_delete_jobs','no' );
            $job_bm_job_login_page_id           = get_option('job_bm_job_login_page_id');
            $job_bm_job_login_page_url          = get_permalink($job_bm_job_login_page_id);


            $display_edit = 'yes';
            $display_delete = 'yes';

            if ( is_user_logged_in() ){

                $userid                     = get_current_user_id();
                $job_bm_list_per_page       = get_option('job_bm_list_per_page');
                $job_bm_job_type_bg_color   = get_option('job_bm_job_type_bg_color');
                $job_bm_job_status_bg_color = get_option('job_bm_job_status_bg_color');
                $job_bm_featured_bg_color   = get_option('job_bm_featured_bg_color');
                $job_bm_job_edit_page_id    = get_option('job_bm_job_edit_page_id');
                $job_bm_job_edit_page_url   = get_permalink($job_bm_job_edit_page_id);
                $job_bm_list_per_page       = !empty($job_bm_list_per_page) ? $job_bm_list_per_page : 10;



                if ( get_query_var('paged') ) {
                    $paged = get_query_var('paged');
                } elseif ( get_query_var('page') ) {
                    $paged = get_query_var('page');
                } else {
                    $paged = 1;
                }


                $wp_query = new WP_Query(
                    array (
                        'post_type' => 'location',
                        'post_status' => 'any',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'author' => $userid,
                        'posts_per_page' => $job_bm_list_per_page,
                        'paged' => $paged,
                    )
                );

                ?>
                <div class="locations-list">
                    <?php

                    $class_job_bm_functions = new class_job_bm_functions();
                    $class_job_bm_applications = new class_job_bm_applications();

                    $job_type_filters = $class_job_bm_functions->job_type_list();
                    $job_level_filters = $class_job_bm_functions->job_level_list();
                    $job_status_filters = $class_job_bm_functions->job_status_list();


                    if ( $wp_query->have_posts() ) :
                        while ( $wp_query->have_posts() ) : $wp_query->the_post();

                            $location_id         = get_the_id();

                            do_action('job_bm_my_locations_loop', $location_id);


                        endwhile;

                        ?>
                        <div class="paginate">
                            <?php
                            $big = 999999999; // need an unlikely integer
                            echo paginate_links( array(
                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'format' => '?paged=%#%',
                                'current' => max( 1, $paged ),
                                'total' => $wp_query->max_num_pages
                            ) );

                            ?>
                        </div>
                        <?php

                        wp_reset_query();

                    else:

                        echo sprintf(__('%s You haven\'t created any location.', 'job-board-manager-locations'), '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>');

                    endif;


                    ?>
                </div>
                <?php
            }
            else{
                echo sprintf(__('Please <a href="%s">login</a> to see your locations.', 'job-board-manager-locations' ), $job_bm_job_login_page_url );

            }

            ?>

        <?php

    }

endif;



add_action('job_bm_my_locations_loop','job_bm_my_locations_loop_wrap_start');

if(!function_exists('job_bm_my_locations_loop_wrap_start')){
    function job_bm_my_locations_loop_wrap_start($location_id){


        ?>
        <div class="my-job-card my-job-card-<?php echo $location_id; ?>">



        <?php

    }
}



add_action('job_bm_my_locations_loop','job_bm_my_locations_loop_header');

if(!function_exists('job_bm_my_locations_loop_header')){
    function job_bm_my_locations_loop_header($location_id){

        $class_job_bm_applications = new class_job_bm_applications();

        $job_bm_location_edit_page_id    = get_option('job_bm_location_edit_page_id');
        $job_bm_location_edit_page_url   = get_permalink($job_bm_location_edit_page_id);

        $featured       = get_post_meta($location_id, 'job_bm_featured',true);
        $featured_class = ($featured == 'yes') ? 'featured' : '';


        ?>
        <div class="card-top">
            <div class="card-action">
                <a class="job-id" title="<?php echo __('Location id.', 'job-board-manager-locations'); ?>" href="<?php echo get_permalink($location_id); ?>">#<?php echo
                    $location_id; ?></a>

                <?php if(!empty($job_bm_location_edit_page_id)): ?>
                <a class="job-edit" title="<?php echo __('Location edit.', 'job-board-manager-locations'); ?>" href="<?php echo
                $job_bm_location_edit_page_url; ?>?location_id=<?php echo $location_id; ?>" target="_blank"><i class="fas
                fa-pencil-alt"></i></a>
                <?php endif; ?>


<!--                <span class="location-delete" job-id="--><?php //echo $location_id; ?><!--" title="--><?php //echo __('Location trash.', 'job-board-manager-locations'); ?><!--"><i class="far fa-trash-alt"></i></span>-->
                <span class="job-featured <?php echo $featured_class; ?>" title="<?php echo ($featured=='yes') ?  __('Featured location.', 'job-board-manager-locations') : 'Not featured'; ?>"><i class="fas fa-star"></i></span>


            </div>

        </div>



        <?php

    }
}



add_action('job_bm_my_locations_loop','job_bm_my_locations_loop_body');

if(!function_exists('job_bm_my_locations_loop_body')){
    function job_bm_my_locations_loop_body($location_id){

        $job_bm_job_login_page_id    = get_option('job_bm_job_login_page_id');
        $job_bm_job_login_page_url   = get_permalink($job_bm_job_login_page_id);

        $job_title = get_the_title($location_id);
        $post_date      = get_the_date('Y-m-d');
        $date_format                        = get_option( 'date_format' );

        $expiry_date    = get_post_meta($location_id, 'job_bm_expire_date',true);
        $publish_status = get_post_status($location_id);
        $job_status     = get_post_meta($location_id, 'job_bm_job_status',true);
        $featured       = get_post_meta($location_id, 'job_bm_featured',true);
        $job_type       = get_post_meta($location_id, 'job_bm_job_type',true);
        $job_label = get_post_meta($location_id, 'job_bm_job_level',true);

        $is_featured =  ($featured=='yes') ?  __('Featured location', 'job-board-manager-locations') : __('Not Featured', 'job-board-manager-locations');


        ?>
        <div class="card-body">
            <a title="<?php echo __('Location link.', 'job-board-manager-locations'); ?>" class="job-link meta" href="<?php echo get_permalink($location_id); ?>"><i class="fas fa-external-link-square-alt"></i> <?php echo $job_title; ?></a>

            <span class="post-date meta"><b><?php echo __('Published:', 'job-board-manager-locations'); ?></b> <?php echo date_i18n($date_format,strtotime($post_date)); ?></span>
            <span class="publish-status meta"><b><?php echo __('Publish Status:', 'job-board-manager-locations'); ?></b> <?php echo $publish_status; ?></span>
            <span class="featured meta"><b><?php echo __('Featured:', 'job-board-manager-locations'); ?></b> <?php echo $is_featured; ?></span>
            <?php


            ?>

        </div>



        <?php

    }
}



















add_action('job_bm_my_locations_loop','job_bm_my_locations_loop_wrap_end');

if(!function_exists('job_bm_my_locations_loop_wrap_end')){
    function job_bm_my_locations_loop_wrap_end(){


        ?>

        </div>

        <?php

    }
}













add_action('job_bm_my_locations','job_bm_my_locations_style');

if(!function_exists('job_bm_my_locations_style')){
    function job_bm_my_locations_style(){

        $job_bm_pagination_bg_color         = get_option('job_bm_pagination_bg_color');
        $job_bm_pagination_active_bg_color  = get_option('job_bm_pagination_active_bg_color');
        $job_bm_pagination_text_color       = get_option('job_bm_pagination_text_color');

        ?>
        <style type="text/css">
            .job-bm-my-jobs .paginate .page-numbers.current{
                background: <?php echo $job_bm_pagination_active_bg_color; ?>;
                color: <?php echo $job_bm_pagination_text_color; ?> ;
            }
            .job-bm-my-jobs .paginate a.page-numbers{
                background: <?php echo $job_bm_pagination_bg_color; ?>;
                color: <?php echo $job_bm_pagination_text_color; ?> ;
            }
        </style>
        <?php

    }
}










