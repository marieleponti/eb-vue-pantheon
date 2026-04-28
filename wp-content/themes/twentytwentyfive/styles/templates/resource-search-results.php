<?php

/**
 * Info repo library (search results)
 * 
 * @package inforepo
 */
if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}
?>

    <div class='container library-resource-list-results-section' id="listview-section">


        <?php
        $i = 0;
        $no_columns = 3;

        // $args = array(
        //     'post_type' => 'inforepo_resource', 
        //     'posts_per_page' => 15, // You can adjust this to show more or fewer items
        //     'orderby' => 'date',
        //     'tax_query' =>  array(
        //         'relation' => 'AND',
        //         array(
        //             'taxonomy' => 'research-team',
        //             'field' => 'slug',
        //             'terms' => array('eb-research'),
        //         ),
        //         array(
        //             'taxonomy' => 'special-content',
        //             'field' => 'slug',
        //             'terms' => array('mini-briefs'),
        //         ),
        //     ),
        // );

        // $query = new WP_Query($args);

        // if ($query->have_posts()) :
        //     while ($query->have_posts()) : $query->the_post();

        while (have_posts()) {
            the_post();

            if ($i % $no_columns == 0) {
        ?>
                <div class="row resource-list-row w-140 eb-mn-seccion-row-grid">
                <?php
            }
                ?>
                <div class='col-lg-4 resource-list-column mb-4 eb-mn-seccion-columnas-grid'>

                    <div class="listview-elements eb-mn-contenedor-grid-tarjetas-post rounded-0">
                        <?php
                        get_template_part('template-parts/info-card');
                        ?>
                    </div>

                </div>
                <?php
                $i++;

                if ($i != 0 && $i % $no_columns == 0) {
                ?>
                </div>
                <div class="clearfix"></div>
        <?php
                }
            }
            wp_reset_postdata();

        ?>
        <div id="inforepo-pagination" class="eb-mn-pagination">
            <?php
            inforepo_pagination();
            ?>
        </div>
    </div>
    