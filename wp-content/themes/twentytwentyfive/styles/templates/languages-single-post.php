<?php
$topics = get_field('language');
if ($topics) : ?>
    <div lang='en'>
        <div class='taxonomy-language single-post-categories-display'>
            <!-- <?php echo get_the_term_list($post->ID, 'language', '', ', '); ?> -->
            <?php echo get_the_term_list($post->ID, 'language', '', ', '); ?>
        </div>
    </div>
<?php endif; ?>