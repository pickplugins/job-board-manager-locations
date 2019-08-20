<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('job_bm_top_locations','job_bm_top_locations_list');
function job_bm_top_locations_list($atts){

    $max_item = $atts['max_item'];

    $query_args= array('post_type'=>'location',  'post_status' => 'publish');
    $wp_query= new WP_Query($query_args);


    if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            $location_title = get_the_title();
            $job_query_args= array('post_type'=>'location',  'post_status' => 'publish');
            $job_query = new WP_Query( array( 'post_type'=>'job','meta_key' => 'job_bm_location', 'meta_value' => $location_title ) );
            $job_count_by_location_data[get_the_ID()] = array('name'=> $location_title,'count'=>$job_query->found_posts,'url'=>get_the_permalink());

        endwhile;

        wp_reset_query();
    endif;


    $job_query = new WP_Query( array( 'post_type'=>'job', 'post_status' => 'publish' ) );



    asort($job_count_by_location_data);

    $total = sprintf(__('Total Job Count - %s','job-board-manager-locations'), $job_query->found_posts);

    ?>
    <div class="total">
        <?php echo apply_filters('job_bm_top_locations_total_text', $total); ?>
    </div>
    <?php



    $i=1;
    foreach($job_count_by_location_data as $location_key=>$location_data){

        if($i<= $max_item){

            if($location_data['count']>0){

                $url = $location_data['url'];
                $name = $location_data['name'];
                $count = $location_data['count'];

                ?>
                <div class="single-location">
                    <a href="<?php echo $url; ?>">
                        <?php

                        $list_item =  sprintf(__('%s - %s','job-board-manager-locations'), $name, $count);
                        echo apply_filters('job_bm_top_locations_list_item', $list_item);

                        ?>
                    </a>

                </div>
                <?php
            }

        }

        $i++;
    }





}


