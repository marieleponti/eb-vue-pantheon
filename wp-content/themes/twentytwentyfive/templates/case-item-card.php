<div class="case-item">
    <a href="<?php the_permalink(); ?>">
        <h5 class="post-title eb-mn-tarjeta-post-titulo"> <?php the_title(); ?> </h5>
    </a>

    <div class="card-text eb-mn-tarjeta-post-date"> <?php the_date() ?> </div>

    <?php

    $description = get_field('description');
    if ($description):
        $desc = substr(get_field('description'), 0, 300);

    ?>
        <div>
            <div class="prr-item-description eb-mn-tarjeta-post-descripcion"> <?php echo $desc . ' ...'; ?> </div>
        </div>
    <?php endif; ?>

</div>