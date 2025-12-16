<?php

/** 
 * Template Name: Resource library Map
 *
 * @package inforepo
 */
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}
get_header();
?>

<?php
get_template_part('template-parts/map-search-results-banner');
?>

<main>


        <div class='container' id="content" role="main">


            <div class="container map-container">

            <div class="row mb-4 eb-mn-seccion-boton-map-list-view">
                <div class="col">
                    <button class="filter-button"
                        id="list-view-button" type="submit"
                        value="listview"
                        name="list-view-button">
                        List View
                    </button>
                </div>
            </div>
                <div
                    id="resource-map"
                    class="mapview-elements eb-mn-seccion-mapa border border-secondary border-2">
                </div>
            </div>
           
        </div><!-- #content -->

</main>

<?php 
  $args = array(
    'posts_per_page'    => -1,
    'post_type'     => 'inforepo_resource',
    'meta_query'    => array(
      'relation'      => 'AND',
      array(
        'key'       => 'mapster_map',
        'value'     => null,
        'compare'   => '!='
      ),
      array(
        'key'       => 'mapster_map',
        'value'     => '',
        'compare'   => '!='
      )
    )
  );

  $the_query = new WP_Query($args);
  if ($the_query->have_posts()):
    $i = 0;
    while ($the_query->have_posts()) : $the_query->the_post();
      $pinLink = get_permalink();
      $map = get_field('latlng');
      $pinTitle = get_field('acf_title');
      // $pinTitle = get_field(the_title());
      $i = $i + 1;
    endwhile;
    $quantityEntries = $i;
  endif;
  wp_reset_query();


?>
