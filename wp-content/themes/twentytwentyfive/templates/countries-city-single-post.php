<?php
$countries = get_field('country');
$cities_communities = get_field('city_community');
if ($countries) : ?>

    <div lang='en' class='taxonomy-countries single-post-categories-display'>
        <?php echo get_the_term_list($post->ID, 'country', '', ', '); ?>
    </div>
<?php endif; ?>
<?php
if ($cities_communities) : ?>
    <div lang='en' class='taxonomy-city_community single-post-categories-display'>
        <?php echo get_the_term_list($post->ID, 'city_community', '', ', '); ?>
    </div>
<?php endif; ?>