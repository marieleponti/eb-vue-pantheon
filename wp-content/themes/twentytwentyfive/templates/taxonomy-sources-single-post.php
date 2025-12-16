<?php
$topics = get_field('source');
if ($topics) : ?>
    <div lang='en'>
        <div class='taxonomy-source single-post-categories-display'>
            <!-- <?php echo get_the_term_list($post->ID, 'source', '', ', '); ?> -->
            <?php echo get_the_term_list($post->ID, 'source', '', ', '); ?>
        </div>
    </div>
<?php endif; ?>