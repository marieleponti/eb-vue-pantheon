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

<div class='eb-research-section'>


    <div class="container">
        <h1 class="secondfont mb-3 font-weight-bold">Exposing the Everywhere Border</h1>

        <div class="jumbotron jumbotron-fluid mb-3 pt-0 pb-0 bg-lightblue position-relative">
            <div class="pl-4 pr-0 h-100 tofront">
                <div class="row justify-content-between">
                    <div class="col-md-6 pt-6 pb-6 align-self-center">
                        <p class="mb-3">
                            The US is building a digital border infrastructure in neighbouring countries that expands and deepens surveillance, while hiding state violence.
                            The implications of this new infrastructure will be long-lasting and need to be integrated into strategies of resistance of migrant justice movements worldwide.
                        </p>
                    </div>
                    <div class="col-md-6 d-none d-md-block pr-0 caption">
                        <figure>
                            <picture>
                                <!-- Add the <img> tag here to ensure the image is displayed -->
                                <img src="/wp-content/themes/divi-child/assets/images/border-tech.jpg" alt="Description of the image" style="width: 100%; height: auto;">
                            </picture>
                            <figcaption class='caption'>Illustration by Zoran Svilar</figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Header -->


        <!--------------------------------------
MAIN
--------------------------------------->
        <section class="featured-research">
            <div class="container">
                <h2>Featured Research</h2>
                <div class="research-list">
                    <?php
                    // Query for featured research
                    $args = array(
                        'post_type' => 'inforepo_resource', // Changed to 'research'
                        'posts_per_page' => 6, // You can adjust this to show more or fewer research items
                        'orderby' => 'date',
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
                                'terms' => array('mini-briefs'),
                            ),
                        ),
                    );


                    $query = new WP_Query($args);
                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                    ?>
                            <div class="research-item">
                                <a href="<?php the_permalink(); ?>" class="research-link">
                                    <div class="research-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="research-content">
                                        <h3 class="research-title"><?php the_title(); ?></h3>
                                        <p class="research-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                                        <div class="research-meta">
                                            <span class="research-author">by <?php echo get_field('author'); ?></span>
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
            </div>
        </section>