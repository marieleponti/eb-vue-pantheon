<?php
if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}
?>

<section class="featured-research">
    <div class="container">
        <div class="research-list">


            <div class="research-item">
                <a href="<?php get_home_url(); ?>/human-impacts-brief/" class="research-link">
                    <div class="research-image-further-reading-further-reading">
                        <img src="/wp-content/themes/twentytwentyfive/assets/images/human_impacts_img2.png" alt="">
                    </div>
                    <div class="research-content">
                        <h3 class="research-title">Human Impacts</h3>
                        <p class="research-excerpt"> </p>
                        <div class="research-meta">
                            <span class="research-author">Laura Bingham</span>
                            <div class="card-text eb-mn-tarjeta-post-date"> February 21, 2025 </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="research-item">
                <a href="<?php get_home_url(); ?>/border-externalization-in-americas/" class="research-link">
                    <div class="research-image-further-reading">
                        <img src="/wp-content/themes/twentytwentyfive/assets/images/minibrief_border-ext_img.jpg" alt="">
                    </div>
                    <div class="research-content">
                        <h3 class="research-title">Border Externalization in the Americas</h3>
                        <p class="research-excerpt"> </p>
                        <div class="research-meta">
                            <span class="research-author">Mizue Aizeki and Santiago Narváez</span>
                            <div class="card-text eb-mn-tarjeta-post-date"> February 20, 2025 </div>
                        </div>
                    </div>
                </a>
            </div>


            <?php
            // Query for featured research
            $args = array(
                'post_type' => 'inforepo_resource',
                'posts_per_page' => 1,
                'orderby' => 'rand',
                'tax_query' =>  array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'research-team',
                        'field' => 'slug',
                        'terms' => array('eb-research'),
                    ),
                    array(
                        'taxonomy' => 'special-content',
                        'field' => 'slug',
                        'terms' => array('featured'),
                    ),
                    array(
                        'taxonomy' => 'source',
                        'field'    => 'slug',
                        'terms'    => array('public-records-requests'),
                        'operator' => 'NOT IN',
                    )

                ),
            );


            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
            ?>
                    <div class="research-item">
                        <a href="<?php the_permalink(); ?>" class="research-link">
                            <div class="research-image-further-reading">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="research-content">
                                <h3 class="research-title"><?php the_title(); ?></h3>
                                <p class="research-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                                <div class="research-meta">
                                    <span class="research-author"><?php echo get_field('author'); ?></span>
                                    <div class="card-text eb-mn-tarjeta-post-date"> <?php the_date() ?> </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p>No featured research found. <a href="/research">Browse all research</a>.</p>
            <?php endif; ?>
        </div>
</section>
</div>