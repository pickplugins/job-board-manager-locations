<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

?>
<div class="job-bm-job-submit location-submit">
    <?php
    if(!empty($_POST)){
        do_action('job_bm_location_submit_data', $_POST);
    }
    ?>
    <?php do_action('job_bm_location_submit_before'); ?>
    <form enctype="multipart/form-data" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <?php
		do_action('job_bm_location_submit_form');
		?>
    </form>
	<?php do_action('job_bm_location_submit_after'); ?>
</div>