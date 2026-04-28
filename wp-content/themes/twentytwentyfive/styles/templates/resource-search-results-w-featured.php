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

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args1 = array(
        'post_type' => 'inforepo_resource', // Replace with your post type if needed
        'tax_query' => array(
            array(
                'taxonomy' => 'special-content',
                'field'    => 'slug',
                'terms'    => 'featured',
            ),
        ),
        'posts_per_page' => 15, 
        'paged' => $paged, 
    );

    $query1 = new WP_Query($args1);

    // Get the IDs of the posts from the first query
    $post_ids = array();
    if ($query1->have_posts()) {
        while ($query1->have_posts()) {
            $query1->the_post();
            $post_ids[] = get_the_ID();
        }
    }

    $remaining_posts = 15 - $query1->post_count;

    // Second query: Get all other posts excluding the ones already fetched
    $args2 = array(
        'post_type' => 'inforepo_resource', // Replace with your post type if needed
        'post__not_in' => $post_ids, // Exclude posts from the first query
        'posts_per_page' => $remaining_posts,
        'paged' => $paged, 
    );

    $query2 = new WP_Query($args2);

    // Combine the results of both queries
    $combined_query = new WP_Query();
    $combined_query->posts = array_merge($query1->posts, $query2->posts);
    $combined_query->post_count = $query1->post_count + $query2->post_count;

    // Loop through the combined query
    if ($combined_query->have_posts()) {
        while ($combined_query->have_posts()) {
            $combined_query->the_post();

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
        }
    ?>
    <div id="inforepo-pagination" class="eb-mn-pagination">
        <?php
        inforepo_pagination();
        ?>
    </div>
</div>