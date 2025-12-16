<?php

/**
 * Featured Research
 * 
 * @package inforepo
 */
if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}
?>

<div class='eb-research-section'>


    <div class="container">
        <h1 class="secondfont mb-3 font-weight-bold"> <?php echo esc_html__('The Everywhere Border Featured Research', 'inforepo'); ?>
        </h1>

        <div class="jumbotron jumbotron-fluid mb-3 pt-0 pb-0 bg-lightblue position-relative">
            <div class="pl-4 pr-0 h-100 tofront">
                <div class="row justify-content-between">
                    <div class="col-md-6 pt-6 pb-6 align-self-center">
                        <p class="mb-3"> <?php echo esc_html__('
                            The United States is building a digital border infrastructure in neighbouring countries that expands and deepens surveillance,
                            while obscuring state violence. The implications of these infrastructures are long-lasting and need to be integrated into strategies
                            of resistance of migrant justice movements worldwide. Since 2023, The Everywhere Border project has been engaged in research to surface
                            information on the infrastructures put in place throughout Latin America in the service of deterrence and its human impacts on people on
                            the move and civil society at large. Our original research outputs are available below.
                            ', 'inforepo'); ?>
                        </p>
                    </div>
                    <div class="col-md-6 d-none d-md-block pr-0 caption">
                        <figure>
                            <picture>
                                <!-- Add the <img> tag here to ensure the image is displayed -->
                                <img src="/wp-content/themes/divi-child/assets/images/border-tech.jpg" alt="Description of the image" style="width: 100%; height: auto;">
                            </picture>
                            <figcaption class='caption'><a href='https://www.instagram.com/chewsomebubblegum/' target="_blank"><?php echo esc_html__('Illustration by Zoran Svilar', 'inforepo'); ?></a></figcaption>
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
                <h2> <?php echo esc_html__('Featured Research', 'inforepo'); ?></h2>
                <div class="research-list">

                    <div class="research-item">
                        <a href="<?php get_home_url(); ?>/border-externalization-in-americas/" class="research-link">
                            <div class="research-image">
                                <img src="/wp-content/themes/divi-child/assets/images/minibrief_border-ext_img.jpg" alt="">
                            </div>
                            <div class="research-content">
                                <h3 class="research-title"><?php echo esc_html__('Border Externalization in the Americas', 'inforepo'); ?></h3>
                                <p class="research-excerpt"> </p>
                                <div class="research-meta">
                                    <span class="research-author"><?php echo esc_html__('Mizue Aizeki and Santiago Narváez', 'inforepo'); ?></span>
                                    <div class="card-text eb-mn-tarjeta-post-date"> <?php echo esc_html__('February 20, 2025', 'inforepo'); ?></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <?php
                    $user = wp_get_current_user();
                    $allowed_roles = array('ebteam', 'administrator', 'ebcommunity');
                    if (array_intersect($allowed_roles, $user->roles)) {  ?>
                        <div class="research-item">
                            <a href="<?php get_home_url(); ?>/biometrics-based-migration-management/" class="research-link">
                                <div class="research-image">
                                    <img src="/wp-content/themes/divi-child/assets/images/portada-advertencia-CUID.jpg" alt="">
                                </div>
                                <div class="research-content">
                                    <h3 class="research-title"><?php echo esc_html__('Biometrics-Based Migration Management Infrastructures', 'inforepo'); ?></h3>
                                    <p class="research-excerpt"> </p>
                                    <div class="research-meta">
                                        <span class="research-author"><?php echo esc_html__('Santiago Narváez', 'inforepo'); ?></span>
                                        <div class="card-text eb-mn-tarjeta-post-date"> <?php echo esc_html__('February 20, 2025 ', 'inforepo'); ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>


                    <div class="research-item">
                        <a href="<?php get_home_url(); ?>/human-impacts-brief/" class="research-link">
                            <div class="research-image">
                                <img src="/wp-content/themes/divi-child/assets/images/human_impacts_img2.png" alt="">
                            </div>
                            <div class="research-content">
                                <h3 class="research-title"><?php echo esc_html__('Human Impacts', 'inforepo'); ?></h3>
                                <p class="research-excerpt"> </p>
                                <div class="research-meta">
                                    <span class="research-author"><?php echo esc_html__('Laura Bingham', 'inforepo'); ?></span>
                                    <div class="card-text eb-mn-tarjeta-post-date"> <?php echo esc_html__('February 21, 2025', 'inforepo'); ?> </div>
                                </div>
                            </div>
                        </a>
                    </div>

                       <div class="research-item">
                        <a href="<?php get_home_url(); ?>/biometrics-mx-ca/" class="research-link">
                            <div class="research-image">
                                <img src="/wp-content/themes/divi-child/assets/images/biometrics-mx-ca.jpg" alt="">
                            </div>
                            <div class="research-content">
                                <h3 class="research-title"><?php echo esc_html__('Biometrics & Borders', 'inforepo'); ?></h3>
                                <p class="research-excerpt"> </p>
                                <div class="research-meta">
                                    <span class="research-author"><?php echo esc_html__('The Everywhere Border Project', 'inforepo'); ?></span>
                                    <div class="card-text eb-mn-tarjeta-post-date"> <?php echo esc_html__('September 1, 2025', 'inforepo'); ?> </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <?php
                    // Query for featured research
                    $args = array(
                        'post_type' => 'inforepo_resource',
                        'posts_per_page' => 6,
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
                                    <div class="research-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="research-content">
                                        <h3 class="research-title"><?php the_title(); ?></h3>
                                        <p class="research-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                                        <div class="research-meta">
                                            <span class="research-author"><?php echo get_field('author'); ?></span>
                                            <?php
                                                                                                                                                                                                             $format = has_filter('wpml_translate_single_string')
                                                ? apply_filters(
                                                    'wpml_translate_single_string',
                                                    'F j, Y',                    // Default value
                                                    'inforepo',                   // Text domain
                                                    'Card Date Format'            
                                                )
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   : __('F j, Y', 'inforepo');      // Fallback if WPML not active

                                            // Format the date
                                            $date = date_i18n($format, get_post_time());
                                            ?>
                                            <div class="card-text eb-mn-tarjeta-post-date"> <?php printf( esc_html__( '%s', 'inforepo' ), $date ); ?></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <p><?php echo esc_html__('No featured research found.', 'inforepo'); ?>< <a href="/research"><?php echo esc_html__('Browse all research', 'inforepo'); ?></a>.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>