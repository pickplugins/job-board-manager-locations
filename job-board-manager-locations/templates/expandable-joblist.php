<?php

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$loc_expand = array();
	
	$wp_query = new WP_Query(
		array (
			'post_type' 	=> 'location',
			'orderby' 		=> 'Date',
			'order' 		=> 'DESC',
			'post_status' 	=> 'publish',
		) 
	);
	
	if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();	
		
		$location = get_the_title();
		$job_bm_location_country_code = get_post_meta( get_the_ID(), 'job_bm_location_country_code', true );
		
		$wp_query_job = new WP_Query(
			array (
				'post_type' 	=> 'job',
				'post_status' 	=> 'publish',
				'meta_query' => array(
					array(
						'key'     => 'job_bm_location',
						'value'   => $location,
						'compare' => 'LIKE',
					),
				),
		) );
		
		$i = 0;
		if ( $wp_query_job->have_posts() ) : while ( $wp_query_job->have_posts() ) : $wp_query_job->the_post();	
			$i++;
		
			$loc_expand[$job_bm_location_country_code][$location][$i] = get_the_ID();
		
		endwhile; endif;
		wp_reset_query();
	
	endwhile; endif;
	wp_reset_query();
	
	
	$class_job_bm_locations_functions = new class_job_bm_locations_functions();
	$job_bm_locations_country_list = $class_job_bm_locations_functions->job_bm_locations_country_list();
	
	?>
    <div class="job_bm_expand_loc">
        <ul>
    <?php

	
	foreach( $loc_expand as $country => $locations ){
		
		
		if(!empty($job_bm_locations_country_list[$country]))
		?>
            <li><a href="#"><?php echo $job_bm_locations_country_list[$country]; ?></a>
                <ul>
                    <?php

                    foreach( $locations as $location => $jobs ){

                        ?>
                        <li>
                            <a href="#"><?php echo $location; ?></a>
                            <ul>
                                <?php

                                foreach( $jobs as $serial => $job_id ){
                                    ?>
                                    <li><a   href="<?php echo get_the_permalink($job_id); ?>"><i class="fa fa-dot-circle-o"></i>  <?php echo get_the_title($job_id); ?></a></li>
                                    <?php
                                }

                                ?>
                            </ul>

                        </li>

                        <?php
                    }

                    ?>
             </ul>
		</li>
        <?php
	}
	
?>

        </ul>
    </div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	