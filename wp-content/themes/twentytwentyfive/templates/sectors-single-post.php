<?php
$topics = get_field('sector');
if ($topics) : ?>
    <div lang='en'>
        <div class='taxonomy-sector single-post-categories-display'>
            <!-- <?php echo get_the_term_list($post->ID, 'sector', '', ', '); ?> -->
            <?php echo get_the_term_list($post->ID, 'sector', '', ', '); ?>
        </div>
    </div>
<?php endif; ?>