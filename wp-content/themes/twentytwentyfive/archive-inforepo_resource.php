<?php

/** 
 * Template Name: Resource library
 *
 * @package inforepo
 */
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}
get_header();
?>


    <div class="resource-page">
        <?php
        get_template_part('template-parts/search-results-banner');
        ?>

        <!-- FILTER RESULTS -->
        <?php
        get_template_part('templates/filter-results');
        ?>

        <div class="card-resource-list">

            <div class="card-body">
                <div class='container grid-layout-content-list-right' id="content" role="main">

                    <?php
                    get_template_part('templates/resource-search-results');

                    ?>
                </div><!-- #content -->
            </div>
        </div>

    </div>

</div>
</main>

<?php
get_footer();
?>