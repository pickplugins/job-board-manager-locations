<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


function job_bm_location_single($content) {

    global $post;

    if ($post->post_type == 'location'){

        ob_start();
        include( job_bm_locations_plugin_dir . 'templates/location-single/location-single.php');

        //wp_enqueue_style('job_bm_company_single');
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

add_action('job_bm_location_single', 'job_bm_location_single_header');

function job_bm_location_single_header($location_id){


    $job_bm_locations_map_type = get_option('job_bm_locations_map_type','dynamic');
    $job_bm_locations_map_zoom = get_option('job_bm_locations_map_zoom',12);
    $job_bm_locations_api_key = get_option('job_bm_locations_api_key');

    $job_bm_location_country_code = get_post_meta(get_the_ID(),'job_bm_location_country_code', true);
    $job_bm_location_latlang = get_post_meta(get_the_ID(),'job_bm_location_latlang', true);

    $location_post_data = get_post(get_the_ID());

    if ( !empty($job_bm_location_latlang) )
    {
        $job_bm_location_latlang = explode(',',$job_bm_location_latlang);

        if(!empty($job_bm_location_latlang[0]))
            $job_bm_location_latlang['lat'] =$job_bm_location_latlang[0];
        else $job_bm_location_latlang['lat'] ='';

        if(!empty($job_bm_location_latlang[1]))
            $job_bm_location_latlang['lng'] =$job_bm_location_latlang[1];
        else $job_bm_location_latlang['lng'] ='';

        if(empty($job_bm_locations_map_type))
            $job_bm_locations_map_type = 'static';



        if($job_bm_locations_map_type=='dynamic')
        {
            echo '<div class="map-container"><div id="map"></div></div>';
            echo '
			<script>
				function initMap() {
					var myLatLng = {lat: '.$job_bm_location_latlang['lat'].', lng: '.$job_bm_location_latlang['lng'].'};

					var map = new google.maps.Map(document.getElementById("map"), {
						zoom: '.$job_bm_locations_map_zoom.',
						center: myLatLng
					});
					
					var marker = new google.maps.Marker({
						position: myLatLng,
						map: map,
						title: "'.get_the_title().'"
					});
				}
			</script>
			
			<script async defer src="https://maps.googleapis.com/maps/api/js?signed_in=true&callback=initMap&key='.$job_bm_locations_api_key.'"></script>\';

			
			';

        }
        elseif($job_bm_locations_map_type=='static'){

            // Free Gogole map API doesn't support more than 640x640 'px size image return.

            echo '<div class="map-container"><div id="map"><img  src="https://maps.googleapis.com/maps/api/staticmap?center='.$job_bm_location_latlang['lat'].','.$job_bm_location_latlang['lng'].'&zoom='.$job_bm_locations_map_zoom.'&size=1024x300&markers=color:red|label:C|'.$job_bm_location_latlang['lat'].','.$job_bm_location_latlang['lng'].'&key='.$job_bm_locations_api_key.'"/></div></div>';

        }


        elseif($job_bm_locations_map_type=='none'){

            echo '';
        }

        else{

        }


    }



    echo '<div class="logo"><img src="'.job_bm_locations_plugin_url.'assets/front/images/map.png" /></div>';


    $class_job_bm_locations_functions = new class_job_bm_locations_functions();
    $job_bm_locations_country_list = $class_job_bm_locations_functions->job_bm_locations_country_list();


    echo '<h1 itemprop="name" class="name">'.$location_post_data->post_title;

    if(!empty($job_bm_locations_country_list[$job_bm_location_country_code])){
        echo '<span class="country">'.$job_bm_locations_country_list[$job_bm_location_country_code].'</span>';
    }


    echo '</h1>';





    $location_content = $location_post_data->post_content;

    if(empty($location_content)){

        $job_bm_display_wiki_content = get_option('job_bm_display_wiki_content');

        if(!empty($job_bm_display_wiki_content) && $job_bm_display_wiki_content=='yes'){

            $content = curl_get_contents('https://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&titles='.str_replace(' ','_',$location_post_data->post_title));
            $wiki_content_json = json_decode($content,true);

            //var_dump($wiki_content_json);

            foreach($wiki_content_json['query'] as $query){

                foreach($query as $normalized){

                    $page_content = isset($normalized['extract']) ? $normalized['extract'] : '';
                }
            }

            //var_dump($wiki_content_json);
            //var_dump($wiki_content_json['query']['pages']['56656']['extract']);

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









