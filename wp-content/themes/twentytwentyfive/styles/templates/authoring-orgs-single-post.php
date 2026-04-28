<?php
$author_org = get_field('author_org');
if ($author_org) : ?>

    <div lang='en' class='taxonomy-author-org single-post-categories-display'>
        <?php echo get_the_term_list($post->ID, 'authoring-organization', '', ', '); ?>
    </div>
<?php endif; ?>