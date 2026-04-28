<?php
$topics = get_field('resource_type');
if ($topics) : ?>
    <div lang='en'>
        <div class='taxonomy-type single-post-categories-display'>
            <!-- <?php echo get_the_term_list($post->ID, 'type', '', ', '); ?> -->
            <?php echo get_the_term_list($post->ID, 'type', '', ', '); ?>
        </div>
    </div>
<?php endif; ?>