<?php

/** 
 * Template Name: EB Public Records Requests
 *
 * @package inforepo
 */
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}
get_header();
?>

<div class='container eb-public-records-requests-page-container'>

    <!-- <div class="banner list-layout-banner eb-public-requests-requests-heading"> -->
    <div class="eb-default-font h4 pb-2 mb-4 border-bottom border-secondary border-3 border-bottom-prr" style="color: #2b3f47 !important;">
        <h2 class="eb-default-font section-title"><?php echo esc_html__('Public Records Requests', 'inforepo') ?></h2>
    </div>


    <!--  INTRO TO PUBLIC RECORDS REQUESTS PAGE -->
    <p>
        <?php echo esc_html__('Most of the policies, practices, and players associated with US border externalization are intentionally 
        obscured and those proliferating harmful impacts can act with impunity. There have been numerous efforts by advocates to learn 
        more about US border policing and externalization processes. Below is a collection of public records requests on these issues.', 'inforepo') ?>
    </p>

    <!--  </div> -->



    <!-- <div class='container list-layout-content-list-right' id="content" role="main"> -->

    <?php
    get_template_part('template-parts/eb-records-requests-results');
    ?>
    <!-- </div>#content -->

</div>


<!-- </main> -->
<?php
// get_footer();
?>