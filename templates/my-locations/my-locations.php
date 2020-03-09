<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


do_action('job_bm_my_locations_before');
?>
<div class="job-bm-my-jobs job-bm-my-locations">
    <?php
    do_action('job_bm_my_locations');
    ?>
</div>
<?php
do_action('job_bm_my_locations_after');