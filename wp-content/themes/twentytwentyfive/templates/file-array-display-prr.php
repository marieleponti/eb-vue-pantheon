<?php
/**
 * Function that defines shortcode inforepo_file_display to display the file array
 * if any files were uploaded in the ACF repeater field 'upload_files'
 * Also used for Legal Filings and Production for Public Records Requests posts
 */
add_shortcode('inforepo_file_display', 'inforepo_display_post_file');
function inforepo_display_post_file()
{
  ob_start();
  ?>
  <div class="single-post-categories-display">

    <?php
    if (have_rows('upload_files')):
      while (have_rows('upload_files')) : the_row();
        $file = get_sub_field('upload_file');

        if ($file) :

          // Extract variables.
          $url = $file['url'];
          $title = $file['title'];
          $caption = $file['caption'];
          $date = $file['date'];
          $description = $file['description'];
          // $icon = $file['icon'];

          // Display image thumbnail when possible.
          // if ($file['type'] == 'image') {
          //   $icon =  $file['sizes']['thumbnail'];
          // }

          if ($caption) : ?>
            <div class="legal-filings-production-prr-post">
            <?php endif; ?>

            <div class="file-name-and-date">
              <a href="<?php echo esc_attr($url); ?>" title="<?php echo esc_attr($title); ?>">
                <span class="flp-title"><?php echo esc_html($title); ?> </span>
              </a>
              <?php
              if ($caption) : ?>
                <p class="flp-caption-date"><?php echo esc_html($caption); ?></p>
            </div>
          <?php endif; ?>

          <?php
          if ($description) : ?>
            <p class="flp-description"><?php echo esc_html($description); ?></p>
          <?php endif; ?>

            </div> <!-- class="legal-filings-production-prr-post" -->

        <?php endif;
      endwhile;
    else :
    // no rows found
    endif;

    return ob_get_clean();
  }
?>