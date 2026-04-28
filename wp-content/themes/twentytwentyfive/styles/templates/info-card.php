<?php
if (! defined('ABSPATH')) {
  die('Direct access forbidden.');
}
?>
<div lang='en' class="card post-card eb-mn-tarjeta-post-contenedor-exterior rounded-0">
  <div class="bg-image hover-overlay eb-mn-tarjeta-post-contenedor-imagen rounded-0" data-mdb-ripple-init data-mdb-ripple-color="light">
    <?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
    if (has_post_thumbnail()) {
    ?>
      <img src="<?php echo $thumbnail[0]; ?>" class="card-img-top eb-mn-tarjeta-post-imagen rounded-0" />
    <?php
    }
    ?>
  </div>
  <div class="card-body eb-mn-tarjeta-post-cuerpo-tarjeta">
    <a href="<?php the_permalink(); ?>">
      <h5 class="eb-mn-tarjeta-post-titulo"> <?php the_title(); ?> </h5>
    </a>

    <!-- <div class="card-text eb-mn-tarjeta-post-date"> the_date() </div> -->

    <?php

    $description = get_field('description');
    if ($description):
      $desc = substr(get_field('description'), 0, 200);

    ?>
      <div>
        <div class="card-text eb-mn-tarjeta-post-descripcion"> <?php echo $desc . ' ...'; ?> </div>
      </div>
    <?php endif; ?>

    <div class="eb-mn-tarjeta-post-boton-leer-container">
      <a href="<?php the_permalink(); ?>" class="eb-mn-tarjeta-post-boton-leer rounded-0">read more</a>
    </div>
  </div>
</div>