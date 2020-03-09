<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


function job_bm_location_single($content) {

    global $post;

    if (is_singular('location') && $post->post_type == 'location'){

        ob_start();
        include( job_bm_locations_plugin_dir . 'templates/location-single/location-single.php');

        wp_enqueue_style('job_bm_location_single');
        //wp_enqueue_style('font-awesome-5');
        //wp_enqueue_script('job-bm-single-company');


        return ob_get_clean();
    }
    else{
        return $content;
    }

}
add_filter( 'the_content', 'job_bm_location_single' );


add_filter( 'wp_title', 'job_bm_locations_wp_title');

function job_bm_locations_wp_title($title){

    $post_type = get_post_type( get_the_ID() );

    if ( is_singular() && $post_type == 'location' ) {
        // Modify $title as required

        $title = sprintf(__('Jobs in %s', 'job-board-manager-locations'), $title);
    }


    return $title;
}

add_action('job_bm_location_single', 'job_bm_location_single_header_1');



add_action( 'job_bm_location_single', 'job_bm_location_single_preview', 5 );
if ( ! function_exists( 'job_bm_location_single_preview' ) ) {
    function job_bm_location_single_preview(){

        if(is_preview()):
            ?>
            <div class="preview-notice"><?php echo __('This is preview of your location, please do not share link.','job-board-manager'); ?></div>
        <?php
        endif;

    }
}








function job_bm_location_single_header_1($location_id){


    ?>
    <div class="location-header">
        <?php

        do_action('job_bm_location_single_header', $location_id)

        ?>
    </div>
    <?php


}





add_action('job_bm_location_single_header', 'job_bm_location_single_header');

function job_bm_location_single_header($location_id){

    $job_bm_locations_map_type = get_option('job_bm_locations_map_type','cover_image');
    $job_bm_locations_map_zoom = get_option('job_bm_locations_map_zoom',12);
    $job_bm_locations_api_key = get_option('job_bm_locations_api_key');

    $job_bm_location_country_code = get_post_meta($location_id,'job_bm_location_country_code', true);
    $job_bm_location_latlang = get_post_meta($location_id,'job_bm_location_latlang', true);



    $job_bm_location_latlang = explode(',',$job_bm_location_latlang);

    $job_bm_location_latlang['lat'] = isset($job_bm_location_latlang[0]) ? $job_bm_location_latlang[0] : '';
    $job_bm_location_latlang['lng'] =isset($job_bm_location_latlang[1]) ? $job_bm_location_latlang[1] : '';


    if($job_bm_locations_map_type=='dynamic') {
        wp_enqueue_script('maps.google.js');

        ?>
        <div class="map-container"><div id="map"></div></div>
        <script>
            function initMap() {
                var myLatLng = {lat: <?php echo $job_bm_location_latlang['lat']; ?>, lng: <?php echo $job_bm_location_latlang['lng']; ?>};

                var map = new google.maps.Map(document.getElementById("map"), {
                    zoom: <?php echo $job_bm_locations_map_zoom; ?>,
                    center: myLatLng
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: "<?php echo get_the_title(); ?>"
                });
            }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?signed_in=true&callback=initMap&key=<?php echo $job_bm_locations_api_key; ?>"></script>
        <?php

    }
    elseif($job_bm_locations_map_type=='static'){
        wp_enqueue_script('maps.google.js');
        // Free Gogole map API doesn't support more than 640x640 'px size image return.


        $map_img_url = 'https://maps.googleapis.com/maps/api/staticmap?center='.$job_bm_location_latlang['lat'].','.$job_bm_location_latlang['lng'].'&zoom='.$job_bm_locations_map_zoom.'&size=1024x300&markers=color:red|label:C|'.$job_bm_location_latlang['lat'].','.$job_bm_location_latlang['lng'].'&key='.$job_bm_locations_api_key;

        $headers = @get_headers($map_img_url);

// Use condition to check the existence of URL
        if($headers && strpos( $headers[0], '200')) {
            ?>
            <div class="map-container">
                <div id="map">
                    <img  src="<?php echo $map_img_url; ?>"/>
                </div>
            </div>
            <?php
        }


    }

    elseif($job_bm_locations_map_type=='cover_image'){
        $job_bm_location_cover = get_post_meta($location_id, 'job_bm_location_cover', true);

        ?>
        <div  class="location-cover">
            <img src="<?php echo $job_bm_location_cover; ?>">
        </div>

        <?php
    }

    elseif($job_bm_locations_map_type=='none'){

        echo '';
    }

    else{

    }

    $class_job_bm_locations_functions = new class_job_bm_locations_functions();
    $job_bm_locations_country_list = $class_job_bm_locations_functions->job_bm_locations_country_list();
    $location_post_data = get_post(get_the_ID());

    ?>
    <div class="location-intro">

        <div class="logo"><img src="<?php echo job_bm_locations_plugin_url.'assets/front/images/map.png'; ?>" /></div>
        <h1 itemprop="name" class="name">
            <?php

            echo $location_post_data->post_title;

            if(!empty($job_bm_locations_country_list[$job_bm_location_country_code])){
                ?>
                <span class="country"><?php echo $job_bm_locations_country_list[$job_bm_location_country_code]; ?></span>
                <?php
            }

            ?>
        </h1>
        <?php









        ?>
    </div>
    <?php




}

add_action('job_bm_location_single', 'job_bm_location_single_description');

function job_bm_location_single_description($location_id){

    $location_post_data = get_post($location_id);

    $location_content = $location_post_data->post_content;

    if(empty($location_content)){

        $job_bm_display_wiki_content = get_option('job_bm_display_wiki_content');

        if(!empty($job_bm_display_wiki_content) && $job_bm_display_wiki_content=='yes'){

            $content = curl_get_contents('https://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&titles='.str_replace(' ','_',$location_post_data->post_title));
            $wiki_content_json = json_decode($content,true);

            //var_dump($wiki_content_json);
            $page_content = '';

            if(!empty($wiki_content_json['query']))
                foreach($wiki_content_json['query'] as $query){

                    foreach($query as $normalized){

                        $page_content = isset($normalized['extract']) ? $normalized['extract'] : '';
                    }
                }

            //var_dump($wiki_content_json);
            //var_dump($wiki_content_json['query']['pages']['56656']['extract']);

            if(!empty($page_content))
                echo '<div class="description"><strong>'.__('Source:', 'job-board-manager-locations').' wikipedia.org</strong><br/>'.$page_content.'</div>';

        }
        else{

            echo '<div class="description"></div>';
        }



    }
    else{
        echo '<div class="description">'.wpautop($location_content).'</div>';
    }


}


add_action('job_bm_location_single', 'job_bm_location_single_jobs');

function job_bm_location_single_jobs($location_id){

    $location_post_data = get_post($location_id);


    echo '<h2 class="job-list-header">'.__(sprintf('Jobs available from - %s', $location_post_data->post_title),'job-board-manager-locations').'</h2>';
    echo do_shortcode('[job_list display_search="no" display_pagination="no" location="'.$location_post_data->post_title.'"]');


}



add_action('job_bm_location_single', 'job_bm_location_single_related');

function job_bm_location_single_related($location_id){


    $check = 0;
    $id = get_the_ID();
    $job_bm_location_country_code = get_post_meta( $id,'job_bm_location_country_code', true);

    $wp_query = new WP_Query(
        array (
            'post_type' => 'location',
            'orderby' => 'Date',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'job_bm_location_country_code',
                    'value' => $job_bm_location_country_code,
                    'compare' => 'LIKE',
                ),
            )
        ) );

    $html = '';
    $html .= '<h2 class="related-location-header">'.__('Related Location', 'job-board-manager-locations').'</h2>';
    $html .= '<div class="related-location-container">';

    if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();
            if( $id != get_the_ID() ): $check = 1;

                $html .= '<div class="single-location">';

                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
                $thumb_url = $thumb['0'];
                if(empty($thumb_url))
                    $thumb_url = job_bm_locations_plugin_url .'assets/front/images/map.png';

                $html .= '<div class="thumb"><a href="'.get_the_permalink().'"><img src="'.$thumb_url.'" /></a></div>';
                $html .= '<span itemprop="name" class="name"><a href="'.get_the_permalink().'">'.get_the_title().'</a></span>';

                $html .= '</div>'; // single location

            endif;
        endwhile;
        wp_reset_query();

        $html .= '</div>'; // location container
    endif;

    if ( $check == 1 ) echo $html;

}









