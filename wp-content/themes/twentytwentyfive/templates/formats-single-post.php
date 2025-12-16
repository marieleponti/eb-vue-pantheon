<?php
$topics = get_field('format');
if ($topics) : ?>
    <div lang='en'>
        <div class='taxonomy-format single-post-categories-display'>
            <!-- <?php echo get_the_term_list($post->ID, 'format', '', ', '); ?> -->
            <?php echo get_the_term_list($post->ID, 'format', '', ', '); ?>
        </div>
    </div>
<?php endif; ?>