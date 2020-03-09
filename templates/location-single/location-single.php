<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

$location_id = get_the_id();

do_action('job_bm_location_single_before', $location_id);

?>
<div itemscope itemtype="http://schema.org/Place" class="location-single">
    <?php
    do_action('job_bm_location_single', $location_id);
    ?>
</div>
<?php
do_action('job_bm_location_single_after', $location_id);


		
