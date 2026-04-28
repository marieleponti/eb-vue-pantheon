<?php
$topics = get_field('topic');
if ($topics) : ?>
    <div lang='en'>
        <div class='taxonomy-topic single-post-categories-display'>
            <!-- <?php echo get_the_term_list($post->ID, 'topic', '', ', '); ?> -->
            <?php echo get_the_term_list($post->ID, 'topic', '', ', '); ?>
        </div>
    </div>
<?php endif; ?>