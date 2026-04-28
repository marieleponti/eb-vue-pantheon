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

<div class='eb-records-requests-results-section'>

    <!-- Featured Cases Section -->
    <section class="featured-cases">
        <div class="h4 pb-2 mb-4 border-bottom border-secondary border-3 border-bottom-prr" style="color: #2b3f47 !important;">
            <h2 class="eb-default-font eb-default-font section-title">
                <?php echo esc_html__('Featured Cases', 'inforepo') ?>
            </h2>
        </div>
        <div class="case-list">
            <?php
            $args = array(
                'post_type' => 'inforepo_resource',
                'posts_per_page' => 3,
                'paged' => 1,
                'tax_query' =>  array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'source',
                        'field' => 'slug',
                        'terms' => array('public-records-requests'),
                    ),
                    // array(
                    //     'taxonomy' => 'research-team',
                    //     'field' => 'slug',
                    //     'terms' => array('eb-research'),
                    // ),
                    array(
                        'taxonomy' => 'special-content',
                        'field' => 'slug',
                        'terms' => array('featured')
                    )
                ),
            );
            $featured_cases = new WP_Query($args);
            if ($featured_cases->have_posts()):
                while ($featured_cases->have_posts()): $featured_cases->the_post();
            ?>
                    <div class="case-item">
                        <a href="<?php the_permalink(); ?>">
                            <h5 class="post-title eb-mn-tarjeta-post-titulo"> <?php the_title(); ?> </h5>
                        </a>

                        <?php

                        $description = get_field('description');
                        if ($description):
                            $desc = substr(get_field('description'), 0, 300);

                        ?>
                            <div>
                                <div class="prr-item-description eb-mn-tarjeta-post-descripcion"> <?php echo $desc . ' ...'; ?> </div>
                            </div>
                        <?php endif; ?>

                    </div>
            <?php

                endwhile;
            endif;
            wp_reset_postdata();
            /***load more button custom code */
            ?>
        </div>

        <div class="read-more eb-mn-tarjeta-post-boton-leer-container">
            <a href="#!" id="load-more" class="eb-mn-tarjeta-post-boton-leer rounded-0">
                <?php echo esc_html__('more cases', 'inforepo') ?>
            </a>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="latest-news">
        <div class="eb-default-font h4 pb-2 mb-4 border-bottom border-secondary border-3 border-bottom-prr" style="color: #2b3f47 !important;">
            <h2 class="eb-default-font section-title">
                <?php echo esc_html__('Updates', 'inforepo') ?>
            </h2>
        </div>
        <div class="news-list">
            <?php
            $args = array(
                'post_type' => 'post', // Default WordPress posts
                'category_name' => 'records-requests-news-and-analysis',
                'posts_per_page' => 3, // Limit to 3 posts
            );
            $latest_news = new WP_Query($args);
            if ($latest_news->have_posts()):
                while ($latest_news->have_posts()): $latest_news->the_post();
            ?>
                    <div class="news-item">
                            <h5 class="post-title eb-mn-tarjeta-post-titulo"> <?php the_title(); ?> </h5>

                        <?php

                        $description = get_field('description');
                        if ($description):
                            $desc = substr(get_field('description'), 0, 300);

                        ?>
                            <div>
                                <div class="prr-item-description eb-mn-tarjeta-post-descripcion"> <?php echo $desc . ' ...'; ?> </div>
                            </div>
                        <?php endif; ?>

                        <div class="updates-prr-content">
                                <?php the_content() ?>
                            </a>
                        </div>
                    </div>
                <?php
                endwhile;
            else:
                ?>
                <p>
                    <?php echo esc_html__('No news available at the moment.', 'inforepo') ?>
                </p>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <!-- Docket Feed Section -->
    <section class="docket-feed">
        <div class="eb-default-font h4 pb-2 mb-4 border-bottom border-secondary border-3 border-bottom-prr" style="color: #2b3f47 !important;">
            <h2 class="eb-default-font section-title" id="docket">
                <?php echo esc_html__('Our Docket', 'inforepo') ?>
            </h2>
        </div>
        <div class="docket-list">
            <?php
            $args = array(
                'post_type' => 'inforepo_resource',
                'posts_per_page' => 3,
                'paged' => get_query_var('paged'),
                'tax_query' =>  array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'source',
                        'field' => 'slug',
                        'terms' => array('public-records-requests'),
                    ),
                    array(
                        'taxonomy' => 'research-team',
                        'field' => 'slug',
                        'terms' => array('eb-research'),
                    )
                )
            );
            $docket_feed = new WP_Query($args);
            if ($docket_feed->have_posts()):
                while ($docket_feed->have_posts()): $docket_feed->the_post();
            ?>
                    <div class="docket-item">
                        <a href="<?php the_permalink(); ?>">
                            <h5 class="post-title eb-mn-tarjeta-post-titulo"> <?php the_title(); ?> </h5>
                        </a>

                        <?php

                        $description = get_field('description');
                        if ($description):
                            $desc = substr(get_field('description'), 0, 300);

                        ?>
                            <div>
                                <div class="prr-item-description eb-mn-tarjeta-post-descripcion"> <?php echo $desc . ' ...'; ?> </div>
                            </div>
                        <?php endif; ?>

                        <!-- hide read more until there are more cases -->
                        <!-- <div class="read-more eb-mn-tarjeta-post-boton-leer-container">
                            <a href="<?php 
                            // the_permalink(); 
                            ?>
                            " class="eb-mn-tarjeta-post-boton-leer rounded-0">
                                <?php 
                                // echo esc_html__('read more', 'inforepo') 
                                ?>
                            </a>
                        </div> -->
                    </div>
            <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>

        </div>

        <div id="inforepo-pagination" class="eb-mn-pagination">
            <?php
            inforepo_pagination_docket($docket_feed);
            ?>
        </div>
    </section>


</div>