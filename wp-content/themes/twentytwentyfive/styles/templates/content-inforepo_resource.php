<?php

/**
 * Content resource post type template file.
 *
 * @package inforepo
 */
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}
?>
    <article lang='en' id='post-<?php the_ID(); ?>' <?php post_class('row'); ?>>
    <?php if (is_single()) {
        the_title('<h1 class=entry-title text-center>', '</h1>');
        the_post_thumbnail();
    } else { ?>
        <div class='imagen medium-6 columns'>
            <?php the_post_thumbnail('entrada'); ?>
        </div>
    <?php } ?>

    <?php if (is_single()) { ?>
        <div>
        <?php } else { ?>
        </div class='medium-6 columns'>
    <?php } ?>

    <header class='entry-header'>
        <?php
        if (is_single()) {
        } else {
            the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
        }

        if ('post' === get_post_type()) : ?>
            <div class="entry-meta">
                <?php get_post_datetime(); ?>
            </div> <!-- .entry-meta -->
        <?php
        endif ?>

    </header><!-- .entry-header -->

    <div lang='en' class="entry-content">
        <?php
        if (is_single()) {
            the_content(); ?>

            <div class='taxonomy'>
                <div class='taxonomy-topic'>
                    <?php echo get_the_term_list($post->ID, 'topic', 'Topics:  ', ', '); ?>
                </div>
                <div class='taxonomy-type'>
                    <?php echo get_the_term_list($post->ID, 'type', 'Type:  ', ', '); ?>
                </div>
                <div class='taxonomy-format'>
                    <?php echo get_the_term_list($post->ID, 'format', 'Formats:  ', ', '); ?>
                </div>
                <div class='taxonomy-Sector'>
                    <?php echo get_the_term_list($post->ID, 'sector', 'Sectors:  ', ', '); ?>
                </div>
            </div>
        <?php
        } else {
            $excerpt = substr(get_the_excerpt(), 0, 200);
            echo $excerpt . ' ...';
        }
        ?>
    </div>

</article>


